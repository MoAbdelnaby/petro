<?php

namespace App\Http\Controllers\Customer;

use App\BranchNetWork;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\BranchModelsRepo;
use App\Models\Branch;
use App\Models\UserModel;
use App\Models\UserModelBranch;
use App\Models\UserPackages;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Validator;

class BranchStatusController extends Controller
{
    protected $repo;

    /**
     * @param BranchModelsRepo $repo
     */
    public function __construct(BranchModelsRepo $repo)
    {
        $this->middleware('permission:list-branchmodels|edit-branchmodels|delete-branchmodels|create-branchmodels', ['only' => ['index', 'store']]);
        $this->middleware('permission:create-branchmodels', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-branchmodels', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-branchmodels', ['only' => ['destroy', 'delete_all']]);
        $this->repo = $repo;
    }

    /**
     * @return Application|Factory|View
     * @throws Exception
     */
    public function branchesStatus(Request $request)
    {

        $branches = Branch::primary()->with('region')->get();
        $on = $branches->where('status',1)->count();
        $off = $branches->where('status',0)->count();
        $installed = $branches->where('installed',1)->count();

        if ($request->online_status === 'online') {

            $branches = Branch::primary()->with('region')
                ->where('last_connected', '>=', Carbon::now()->subMinutes(15))
                ->get();

        } else if ($request->online_status === 'offline') {

            $branches = Branch::primary()->with('region')
                ->where('last_connected', '<=', Carbon::now()->subMinutes(15))
                ->get();

        }
        return view("customer.branches_status.index", compact('branches', 'off', 'on', 'installed'));
    }

    /**
     * @return JsonResponse
     */
    public function getNotLinked(): JsonResponse
    {
        $installed_branch = DB::table('last_error_branch_views')
            ->join('branches', 'branches.code', '=', 'last_error_branch_views.branch_code')
            ->where('branches.installed', true)
            ->select('last_error_branch_views.branch_code as code')
            ->pluck('code')
            ->toArray();

        $not_linked_branches = Branch::whereNotIn('code', $installed_branch)
            ->where('installed', true)
            ->select('name', 'id')
            ->get();

        return response()->json(['not_linked' => $not_linked_branches]);
    }

    /**
     * @param $code
     * @return Application|Factory|View
     */
    public function getLogs($code)
    {
        $branchName = Branch::where('code', $code)->firstOrFail()->name;
        $logs = BranchNetWork::with('user')->where("branch_code", $code)->get();

        return view("customer.branches_status.logs", compact('logs', 'branchName'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function lastStability(Request $request): JsonResponse
    {
        //Last Stability
        $first_errors = DB::table('branch_net_works')
            ->select('branch_code', DB::raw('MAX(created_at) as start_error'))
            ->where('error', '<>', '"No errors"')
            ->whereYear('created_at', now()->format('Y'))
            ->groupBy('branch_code')
            ->latest()
            ->get();

        $last_stability = [];
        [$from_total, $to_total] = $this->handleRangeTime($request);

        foreach ($first_errors as $error) {
            $last_stability[$error->branch_code] = DB::table('branch_net_works')
                ->select('branch_code', DB::raw('MIN(created_at) as start_date'), DB::raw('MAX(created_at) as end_date'))
                ->where('error', '=', '"No errors"')
                ->where('branch_code', '=', $error->branch_code)
                ->where('created_at', '>=', $error->start_error)
                ->latest()
                ->get()
                ->map(function ($item) use ($from_total, $to_total) {
                    $diffMinutes = Carbon::parse($item->start_date)->diffInMinutes($item->end_date);

                    $from_range = true;
                    if ($from_total != 0) {
                        $from_range = $diffMinutes > $from_total;
                    }
                    $to_range = true;
                    if ($to_total != 0) {
                        $to_range = $diffMinutes < $to_total;
                    }
                    if ($from_range && $to_range) {
                        return [
                            'start_date' => $item->start_date,
                            'end_date' => $item->end_date,
                            'stability' => handleDiff(Carbon::parse($item->start_date)->diff($item->end_date))
                        ];
                    }
                    return [];
                })->first();
        }

        $filter_status = false;
        if ($from_total != 0 || $to_total != 0) {
            $filter_status = true;
        }

        return response()->json(['stabiliteis' => $last_stability, 'filter_status' => $filter_status]);
    }

    /**
     * @param Request $request
     * @param $code
     * @return Application|Factory|View
     */
    public function getStability(Request $request, $code)
    {
        $branch = Branch::where('code', $code)->firstOrFail();
        $start = Carbon::now()->startOfYear();
        $end = Carbon::now();

        if ($request->start) {
            $start = $request->start;
        }

        if ($request->end) {
            $end = $request->end;
        }

        $steps = $this->stepsQuery($code, $start, $end);
        $charts = $this->prepareChart($steps);
        $info = ["list" => 'start_date', "unit" => "Hours"];

        return view("customer.branches_status.steps", compact('branch', 'steps', 'info', 'charts'));
    }

    /**
     * @param $code
     * @param $start
     * @param $end
     * @return array
     */
    protected function stepsQuery($code, $start, $end): array
    {
        $steps = DB::table('branch_net_works')
            ->select('branch_net_works.*')
            ->where('branch_code', '=', $code)
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->latest()
            ->get();

        return $steps->chunkWhile(function ($value, $key, $chunk) {
            return $value->error == $chunk->last()->error;
        })->map(function ($createdChunk) {
            return [
                'status' => $createdChunk->first()->error == '"No errors"' ? 'stable' : 'not_stable',
                'start_date' => Carbon::parse($createdChunk->last()->created_at)->subMinutes(15)->format('Y-m-d h:i A'),
                'end_date' => Carbon::parse($createdChunk->first()->created_at)->format('Y-m-d h:i A'),
                'stability' => handleDiff(Carbon::parse($createdChunk->last()->created_at)->subMinutes(15)->diff($createdChunk->first()->created_at)),
            ];
        })->toArray();
    }

    /**
     * @param $charts
     * @return Collection
     */
    private function prepareChart($charts): Collection
    {
        return collect($charts)->map(function ($item) {
            $item = (object)$item;
            return [
                'date' => Carbon::parse($item->start_date)->format('Y-m-d H:i:s'),
                'value' => $item->status == 'stable' ? 1 : 0,
            ];
        });
    }

    /**
     * @param $request
     * @return array
     */
    private function handleRangeTime($request): array
    {
        $from_day = 0;
        $from_hour = 0;
        $from_minute = 0;
        $to_day = 0;
        $to_hour = 0;
        $to_minute = 0;
        if (!is_null($request->from_day)) {
            $from_day = $request->from_day * 24 * 60;
        }
        if (!is_null($request->from_hour)) {
            $from_hour = $request->from_hour * 60;
        }
        if (!is_null($request->from_minute)) {
            $from_minute = $request->from_minute;
        }

        $from_total = ($from_day + $from_hour + $from_minute);

        if (!is_null($request->to_day)) {
            $to_day = $request->to_day * 24 * 60;
        }
        if (!is_null($request->to_hour)) {
            $to_hour = $request->to_hour * 60;
        }
        if (!is_null($request->to_minute)) {
            $to_minute = $request->to_minute;
        }

        $to_total = ($to_day + $to_hour + $to_minute);

        return [$from_total, $to_total];
    }

    public function UserbranchesStatus(Request $request)
    {
            $user =  User::with('branches')
                ->where('id',auth()->id())
                ->first();
            $ids = $user->branches->pluck('id')->toArray();

        $branches = Branch::primary()->with('region')
            ->whereIn('id',$ids)
            ->get();
        $on = $branches->where('status',1)->whereIn('id',$ids)->count();
        $off = $branches->where('status',0)->whereIn('id',$ids)->count();
        $installed = $branches->where('installed',1)->whereIn('id',$ids)->count();

        if ($request->online_status === 'online') {

            $branches = Branch::primary()->with('region')
                ->where('last_connected', '>=', Carbon::now()->subMinutes(15))
                ->whereIn('id',$ids)
                ->get();

        } else if ($request->online_status === 'offline') {

            $branches = Branch::primary()->with('region')
                ->where('last_connected', '<=', Carbon::now()->subMinutes(15))
                ->whereIn('id',$ids)
                ->get();

        }

        return view("subcustomer.branch-status.index", compact('branches', 'off', 'on', 'installed'));
    }
}
