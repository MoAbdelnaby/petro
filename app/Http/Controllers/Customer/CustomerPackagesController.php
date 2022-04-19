<?php

namespace App\Http\Controllers\Customer;

use App\Console\Commands\BranchStatusApi;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\BranchRepo;
use App\Http\Repositories\Eloquent\CustomerRepo;
use App\Models\Branch;
use App\Models\ModelFeature;
use App\Models\Package;
use App\Models\PackageRequest;
use App\Models\UserModelBranch;
use App\Models\UserPackages;
use App\Notifications\BranchStatusNotification;
use App\Services\ConfigService;
use App\Services\Report\ReportService;
use App\User;
use App\userSetting;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class CustomerPackagesController extends Controller
{
    protected $repo;
    protected $branchRepo;

    /**
     * Create a new controller instance.
     *
     * @param CustomerRepo $repo
     * @param BranchRepo $branchRepo
     */
    public function __construct(CustomerRepo $repo, BranchRepo $branchRepo)
    {
        $this->middleware('permission:list-mypackages|edit-mypackages|delete-mypackages|create-mypackages', ['only' => ['index', 'store']]);
        $this->middleware('permission:create-mypackages', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-mypackages', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-mypackages', ['only' => ['destroy', 'delete_all']]);
        $this->repo = $repo;
        $this->branchRepo = $branchRepo;
    }

    /**
     * @return View
     * @throws Exception
     */
    public function statistics()
    {
        $config = ConfigService::get();
        $query = DB::table('last_error_branch_views');
        $branches = $query->get();
        $on = $query->where('created_at', '>=', Carbon::now()->subMinutes(15))
            ->where('created_at', '<=', Carbon::now())->count();

        Branch::whereNotIn('code', $branches->pluck('branch_code'))->get()->map(function ($item) use ($branches) {
            $branches->push((object)[
                'id' => 111,
                'branch_code' => $item->code,
                'user_id' => $item->user_id,
                'error' => '',
                'created_at' => Carbon::now()->subYear(),
                'updated_at' => Carbon::now()->subYear(),
            ]);
        });
        $off = $branches->count() - $on;

        $report = [];
        foreach (['place', 'plate', 'stayingAverage', 'invoice'] as $type) {
            $filter = $this->getTopBranch($type, request()->all());
            $filter['start'] = $date['start'] ?? now()->startOfYear()->toDateString();
            $filter['end'] = $date['end'] ?? now()->toDateString();
            $report[$type] = ReportService::handle($type, $filter);
        }

        return view('customerhome', [
            'statistics' => ReportService::statistics($filter['start'], $filter['end']),
            'report' => $report,
            'config' => $config,
            'off' => $off,
            'on' => $on
        ]);
    }


    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $package = $this->repo->getactivePackage();
        $allbranches = $this->branchRepo->getactiveBranches();

        if ($package) {

            $items = $this->repo->getPackagesItems($package->id);

            $assignedbranches = UserModelBranch::with('branch')
                ->where('active', 1)
                ->whereIn('user_model_id', $items->pluck('id')->toArray())
                ->get()
                ->groupBy('user_model_id');

            $result = [];
            foreach ($items as $item) {
                $modelfeatures = json_decode($item->features);
                $featurename = [];

                if ($modelfeatures) {
                    $modelfeaturerecords = ModelFeature::whereIn('id', $modelfeatures)->with('feature')->get();
                    foreach ($modelfeaturerecords as $modelfeaturerecord) {
                        $featurename[] = $modelfeaturerecord->feature->name;
                    }
                }

                $itembranches = [];
                foreach ($assignedbranches[$item->id] as $assignedbranch) {
                    if ($assignedbranch->branch) {
                        $itembranches[] = $assignedbranch->branch;
                    }
                }
                $item->itembranches = $itembranches;
                $item->featurenames = $featurename;
                $result[] = $item;
            }

            $items = $result;
        } else {
            $items = [];
        }
        if (Auth::check()) {
            $userSettings = UserSetting::where('user_id', auth()->id())->first();
        }

        return view('customer.packages.index', compact('package', 'items', 'allbranches', 'userSettings'));
    }

    public function search(Request $request)
    {
        return UserPackages::where('price', 'like', '%' . $request->search . '%')
            ->orWhere('name', 'like', '%' . $request->search . '%')->orderBy('id', 'DESC')->paginate(10);
    }

    /**
     * Create the Package for dashboard.
     *
     * @return Renderable
     */
    public function create()
    {
        return view('customer.features.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:features,name,NULL,id,deleted_at,NULL',
            'price' => 'required',

        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $data = [
            'name' => $request->name,
            'price' => $request->price,

        ];

        $insert = $this->repo->create($data);
        return redirect()->route('features.index')->with('success', __('app.customer.features.success_message'));

    }

    /**
     * update the Permission for dashboard.
     *
     * @param Permission $permission
     * @return Renderable
     */
    public function edit($id)
    {
        $item = $this->repo->findOrFail($id);
        return view('customer.features.edit', compact('id', 'item'));

    }

    /**
     * Update a resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:features,name,' . $id . ',id,deleted_at,NULL',
            'price' => 'required',
        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $data = [
            'name' => $request->name,
            'price' => $request->price,

        ];

        $insert = $this->repo->update($data, $id);
        return redirect()->route('features.index')->with('success', __('app.customer.features.success_message'));

    }

    /**
     * Delete more than one permission.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->repo->delete($request->id);
    }

    public function assignuser($id)
    {
        $package = $this->repo->findOrFail($id);
        if ($package) {
            $users = User::where('type', 'subcustomer')->where('parent_id', parentID())->get();
            return view('customer.packages.assignuser', compact('id', 'users'));
        } else {
            return redirect()->back();
        }
    }

    public function assignuserpost(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'package_id' => 'required|exists:packages,id',
            'start_date' => 'required|date|date_format:Y-m-d|before:end_date',
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date',

        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $package = Package::find($request->package_id);
        if ($package->end_date < $request->start_date) {
            return redirect()->back()->withErrors(['start_date' => 'please select start date before package end date'])->withInput();
        }
        if ($package->start_date > $request->start_date) {
            return redirect()->back()->withErrors(['start_date' => 'please select start date after package start date'])->withInput();
        }
        UserPackages::where('user_id', $request->user_id)->where('active', 1)->update([
            'active' => 0
        ]);
        $insert = UserPackages::create([
            'user_id' => $request->user_id,
            'package_id' => $request->package_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        return redirect()->route('customerPackages.index')->with('success', 'User Assigned Successfully');

    }

    public function allpackages()
    {
        $active = $this->repo->getactivePackage();
        $items = $this->repo->getAllPackages();

        return view('customer.packages.all', compact('items', 'active'));
    }


    public function packageDetails($package_id)
    {

        $package = $this->repo->retrievePackage($package_id);
        if ($package) {
            $items = $this->repo->packageDetails($package->id);
            $result = [];
            foreach ($items as $item) {
                $modelfeatures = json_decode($item->features);
                $featurename = [];
                $featurerecord = [];
                $modelfeaturerecord = '';
                if ($modelfeatures) {
                    foreach ($modelfeatures as $modelfeature) {
                        $modelfeaturerecord = ModelFeature::with('feature')->find($modelfeature);
                        $featurename[] = $modelfeaturerecord->feature->name;
                        $featurerecord[] = $modelfeaturerecord->feature;
                    }
                }

                $item->featurenames = $featurename;
                $item->featurerecord = $featurerecord;
                $item->modelfeaturerecord = $modelfeaturerecord;
                $result[] = $item;
            }

            $items = $result;
        } else {
            $items = [];
        }


        return view('customer.packages.packageDetails', compact('package', 'items'));
    }

    public function requestPackage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'package_id' => 'required|exists:packages,id'

        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $package = Package::find($request->package_id);
        if (!$package) {
            return redirect()->back()->with('danger', 'please select active package');
        }


        $insert = PackageRequest::create([
            'user_id' => parentID(),
            'package_id' => $request->package_id,
        ]);
        return redirect()->back()->with('success', 'Your request has been send Successfully');

    }

    public function getTopBranch($type, $filter): array
    {
        $type = !in_array($type, ['place', 'plate']) ? 'place' : $type;
        $branches = DB::table("view_top_branch_$type")->pluck('branch_id')->toArray();

        return [
            'start' => $filter['start'] ?? now()->startOfYear()->toDateString(),
            'end' => $filter['end'] ?? null,
            'show_by' => 'branch',
            'branch_type' => 'comparison',
            'branch_comparison' => $branches,
        ];
    }
}
