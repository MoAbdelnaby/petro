<?php

namespace App\Http\Controllers\Customer;

use App\Exports\ExportFiles;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Region;
use App\Services\ConfigService;
use App\Services\Report\ReportService;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    public array $reportType = [];

    public function __construct()
    {
        $this->reportType = ['place', 'plate', 'invoice', 'welcome', 'backout', 'stayingAverage'];
    }

    public function index(Request $request)
    {
        $branches = Branch::active()->primary()->select('id', 'name')->with('areas')->get();
        $statics = ReportService::statistics($request->start , $request->end, $request->lists);

        if (!empty(request('lists'))) {
            $lists = request('lists');
            if (!is_array($lists)) {
                $lists = str_contains($lists, ',') ? explode(',', (string)$lists) : $lists;
            }
            $lists = \Arr::wrap($lists);
            $list_report = Branch::whereIn('id', $lists)->pluck('name')->toArray();
        }

        return view("customer.reports.index", [
            'statistics' => $statics,
            'branches' => $branches,
            'list_report' => $list_report ?? false
        ]);
    }

    /**
     * @param $type
     * @param Request $request
     * @return Application|Factory|JsonResponse|RedirectResponse|View
     */
    public function show($type, Request $request)
    {
        if (!in_array($type, $this->reportType)) abort(404);

        try {
            $branches = Branch::active()->primary()->select('id', 'name')->with('areas')->get();
            $regions = Region::active()->primary()->child()->select('id', 'name')->get();
            $cities = Region::active()->primary()->parent()->select('id', 'name')->get();

            $filter = (empty($request->except('_token')) || is_null($request->show_by))
                ? $this->getTopBranch($type, $request->all()) : $request->except('_token');

            $result = ReportService::handle($type, $filter);

            if (isset($result['type'])) {
                $list_report = in_array($result['type'], ['region', 'city']) ? Region::query() : Branch::query();

                $list_report = $list_report->active()->primary()->take(6)->whereIn('id', \Arr::wrap($result['list']))->pluck('name');
            }

            return view("customer.reports.type.$type", [
                'branches' => $branches,
                'regions' => $regions,
                'cities' => $cities,
                'report' => $result,
                'config' => ConfigService::get($type),
                'filter_type' => 'comparison',
                'list_report' => $list_report ?? [],
            ]);

        } catch (\Exception $e) {
            return unKnownError($e->getMessage());
        }
    }

    public function getTopBranch($type, $filter): array
    {
        $type = !in_array($type, ['place', 'plate']) ? 'place' : $type;
        $branches = DB::table("view_top_branch_$type")->pluck('branch_id')->toArray();

        return [
            'start' => $filter['start'] ?? now()->startOfYear()->toDateString(),
            'end' => $filter['end'] ?? null,
            'show_by' => 'branch',
            'default' => true,
            'branch_type' => 'comparison',
            'branch_comparison' => $branches,
        ];
    }

    /**
     * @param $type
     * @param Request $request
     * @return JsonResponse|RedirectResponse|BinaryFileResponse
     */
    public function download($type, Request $request)
    {
        try {
            $filter = (empty($request->except('_token')) || is_null($request->show_by))
                ? $this->getTopBranch($type, $request->all()) : $request->except('_token');

            $filter['download'] = true;
            $data = ReportService::handle($type, $filter) ?? [];
            $list = \Arr::flatten($data, 1);

            $start = $request->start ? Carbon::parse($request->start)->format('Y-m-d') : now()->startOfYear()->toDateString();
            $end = $request->end ? Carbon::parse($request->end)->format('Y-m-d') : now()->toDateString();
            $name = "{$type}_excel_file_{$start}_to_{$end}.xls";

            $path = "reports/$type/files";
            $file_path = $path . '/' . $name;
            if (!is_dir(storage_path("/app/public/" . $path))) {
                \File::makeDirectory(storage_path("/app/public/" . $path), 0777, true, true);
            }

            $check = \Excel::store(new ExportFiles($list), '/public/' . $file_path);

            if ($check) {
                $file = public_path() . "/storage/$file_path";
                return \Response::download($file, $name, ['Content-Type: application/xls']);
            }

            return redirect()->back()->with('danger', "Fail To Download File");

        } catch (\Exception $e) {
            return unKnownError($e->getMessage());
        }
    }

    /**
     * @param $region
     * @return Application|Factory|View
     */
    public function getBranchByRegion($region)
    {
        $branches = Branch::active()->primary()->where('region_id', $region)->select('id', 'name')->get();

        return view('customer.reports.extra._branch_by_region', ['branches' => $branches]);
    }

    /**
     * @param $city
     * @return Application|Factory|View
     */
    public function getRegionByCity($city)
    {
        $regions = Region::active()->primary()->where('parent_id', $city)->select('id', 'name')->get();

        return view('customer.reports.extra._region_by_city', ['regions' => $regions]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|BinaryFileResponse
     */
    public function downloadStatistics(Request $request)
    {
        $data = ReportService::downloadStatistics($request->start, $request->end, $request->lists);
        $type = "statistics";
        $start = $request->start ? Carbon::parse($request->start)->format('Y-m-d') : now()->startOfYear()->toDateString();
        $end = $request->end ? Carbon::parse($request->end)->format('Y-m-d') : now()->toDateString();
        $name = "{$type}_excel_file_{$start}_to_{$end}.xls";

        $path = "reports/$type/files";
        $file_path = $path . '/' . $name;
        if (!is_dir(storage_path("/app/public/" . $path))) {
            \File::makeDirectory(storage_path("/app/public/" . $path), 777, true, true);
        }

        $check = \Excel::store(new ExportFiles($data), '/public/' . $file_path);

        if ($check) {
            $file = public_path() . "/storage/$file_path";
            return \Response::download($file, $name, ['Content-Type: application/xls']);
        }

        return redirect()->back()->with('danger', "Fail To Download File");
    }

    public function export($type, Request $request)
    {
        try {
            $filter = (empty($request->except('_token')) || is_null($request->show_by))
                ? $this->getTopBranch($type, $request->all()) : $request->except('_token');

            $result = ReportService::handle($type, $filter);
            $list = \Arr::flatten($result, 2);
            $key_word = in_array(\request('integration'), ['invoice', 'welcome']) ? '' : 'Non_';
            $name = "{$key_word}integration_{$type}_excel_file.xls";
            $path = "reports/$type/files";

            $file_path = $path . '/' . $name;
            if (!is_dir(storage_path("/app/public/" . $path))) {
                \File::makeDirectory(storage_path("/app/public/" . $path), 0777, true, true);
            }

            $check = \Excel::store(new ExportFiles($list), '/public/' . $file_path);

            if ($check) {
                $file = public_path() . "/storage/$file_path";
                return \Response::download($file, $name, ['Content-Type: application/xls']);
            }

            return redirect()->back()->with('danger', "Fail To Download File");

        } catch (\Exception $e) {
            return unKnownError($e->getMessage());
        }
    }

    public function filter(Request $request){
        return $this->index($request);
    }
}
