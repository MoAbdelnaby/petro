<?php

namespace App\Http\Controllers\Models;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\PlacesRepo;
use App\Http\Repositories\Eloquent\PlatesRepo;
use App\Models\Branch;
use App\Models\BranchFiles;
use App\Models\CarPLatesSetting;
use App\Models\PlaceMaintenanceSetting;
use App\Models\Region;
use App\Models\UserModelBranch;
use App\Models\UserPackages;
use App\Services\Report\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BranchesController extends Controller
{
    protected $placesRepo;
    protected $platesRepo;

    public function __construct(PlacesRepo $placesRepo, PlatesRepo $platesRepo)
    {
        $this->placesRepo = $placesRepo;
        $this->platesRepo = $platesRepo;

    }

    public function show($regionid)
    {
        $activeBranch = Branch::where('region_id', $regionid)
            ->where('active', true)
            ->where('user_id', parentID())
            ->first();
        if (!$activeBranch) {
            return redirect()->back()->with('danger', __('app.gym.empty_region'));
        }
        return redirect()->route('branchmodelpreview.index', [$activeBranch->id]);

    }

    public function index($branch_id = null)
    {
        $activepackage = UserPackages::where('user_id', parentID())->where('active', '1')->first();

        if ($branch_id) {

            $query = DB::table('user_model_branches')
                ->select(['user_model_branches.*', 'branches.name as bname', 'models.name as mname', 'lt_models.id as lt_id'])
                ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
                ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
                ->join('models', 'models.id', '=', 'users_models.model_id')
                ->join('lt_models', 'lt_models.id', '=', 'models.lt_model_id')
                ->join('regions', 'regions.id', '=', 'branches.region_id')
                ->whereNull('regions.deleted_at')
                ->where('branches.active', true)
                ->where('regions.active', true)
                ->where('users_models.user_package_id', $activepackage->id)
                ->whereNull('user_model_branches.deleted_at')
                ->whereNull('branches.deleted_at')
                ->whereNull('users_models.deleted_at')
                ->where('branches.id', $branch_id);

            $count = $query->count();
            $items = $query->get();


            if ($count < 1) {
                $user = Auth::user();
                if ($user->type == "subcustomer") {
                    return redirect()->route('myBranches')->with('danger', __('app.gym.empty_branch'));
                } else {
                    return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
                }
            } else {
                if ($items[0]->lt_id == 9) {
                    return redirect()->route('branchmodelpreview.plates', [$branch_id, $items[0]->id]);
                } elseif ($items[0]->lt_id == 8) {
                    return redirect()->route('branchmodelpreview.places', [$branch_id, $items[0]->id]);
                } else {
                    return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotexist'));
                }
            }

        } else {
            // here display all branches
            $query = DB::table('user_model_branches')
                ->select(DB::raw('distinct(branches.id) as b_id,branches.created_at as created_at , branches.name as bname'))
                ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
                ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
                ->join('regions', 'regions.id', '=', 'branches.region_id')
                ->whereNull('branches.deleted_at')
                ->whereNull('regions.deleted_at')
                ->whereNull('user_model_branches.deleted_at')
                ->whereNull('users_models.deleted_at')
                ->where('regions.active', true)
                ->where('branches.active', true)
                ->where('users_models.user_package_id', $activepackage->id)
                ->orderBy('branches.created_at', 'desc');
            $count = $query->count();

            $activebranches = $query->get();
            if ($count < 1) {
                $user = Auth::user();
                if ($user->type == "subcustomer") {
                    return redirect()->route('myBranches')->with('danger', __('app.gym.empty_branch'));
                } else {
                    return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
                }
            } else {
                $branch_id = $activebranches[0]->b_id;

                $query = DB::table('user_model_branches')
                    ->select(['user_model_branches.*', 'branches.name as bname', 'models.name as mname', 'lt_models.id as lt_id'])
                    ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
                    ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
                    ->join('models', 'models.id', '=', 'users_models.model_id')
                    ->join('lt_models', 'lt_models.id', '=', 'models.lt_model_id')
                    ->join('regions', 'regions.id', '=', 'branches.region_id')
                    ->whereNull('regions.deleted_at')
                    ->where('branches.active', true)
                    ->where('regions.active', true)
                    ->where('users_models.user_package_id', $activepackage->id)
                    ->whereNull('user_model_branches.deleted_at')
                    ->whereNull('branches.deleted_at')
                    ->whereNull('users_models.deleted_at')
                    ->where('branches.id', $branch_id);


                $count = $query->count();
                $items = $query->get();

                if ($count < 1) {
                    $user = Auth::user();
                    if ($user->type == "subcustomer") {
                        return redirect()->route('myBranches')->with('danger', __('app.gym.empty_branch'));
                    } else {
                        return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
                    }
                } else {
                    if ($items[0]->lt_id == 8) {
                        return redirect()->route('branchmodelpreview.places', [$branch_id, $items[0]->id]);
                    } else if ($items[0]->lt_id == 9) {
                        return redirect()->route('branchmodelpreview.plates', [$branch_id, $items[0]->id]);
                    } else {
                        return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotexist'));
                    }
                }

            }
        }
    }

    public function places($branch_id, $usermodelbranchid)
    {
        $activepackage = UserPackages::where('user_id', parentID())->where('active', '1')->first();
        $user = Auth::user();
        $activebranches = [];
        $current_branch = Branch::findOrFail($branch_id);
        if ($user->type == "subcustomer") {
            $data = $user->branches;
            $branches = $data->pluck('id')->toArray();
            if (!in_array($branch_id, $branches)) {
                return redirect()->route('myBranches')->with('danger', __('app.gym.empty_branch'));
            }
            foreach ($data as $row) {
                $activebranches[] = (object)[
                    'bname' => $row->name,
                    'b_id' => $row->id,
                ];
            }

        } elseif ($user->type == "customer") {
            if ($current_branch->user_id != $user->id) {
                return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
            }

            $activebranches = DB::table('user_model_branches')
                ->select(DB::raw('distinct (branches.id) as b_id, branches.name as bname'))
                ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
                ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
                ->join('regions', 'regions.id', '=', 'branches.region_id')
                ->whereNull('user_model_branches.deleted_at')
                ->whereNull('branches.deleted_at')
                ->whereNull('regions.deleted_at')
                ->where('branches.region_id', $current_branch->region_id)
                ->where('branches.active', '=', true)
                ->where('regions.active', '=', true)
                ->whereNull('users_models.deleted_at')
                ->where('users_models.user_package_id', $activepackage->id)
                ->get();
        }

        $activeRegions = Region::latest()->where('active', true)->child()->where('user_id', parentID())->get();

        $query = DB::table('user_model_branches')
            ->select(['user_model_branches.*', 'branches.id as b_id', 'branches.name as bname', 'models.name as mname', 'lt_models.id as lt_id'])
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->join('models', 'models.id', '=', 'users_models.model_id')
            ->join('lt_models', 'lt_models.id', '=', 'models.lt_model_id')
            ->join('regions', 'regions.id', '=', 'branches.region_id')
            ->whereNull('regions.deleted_at')
            ->where('branches.active', true)
            ->where('regions.active', true)
            ->where('users_models.user_package_id', $activepackage->id)
            ->whereNull('user_model_branches.deleted_at')
            ->whereNull('branches.deleted_at')
            ->whereNull('users_models.deleted_at')
            ->where('branches.id', $branch_id);

        $count = $query->count();
        $modelswithbranches = $query->get();
        if ($count < 1) {
            return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
        }
        $start = null;
        $end = null;
        $starttime = null;
        $endtime = null;
        $screen = false;
        $notify = false;
        $usermodelbranch = UserModelBranch::whereId($usermodelbranchid)->with('branch', 'usermodel')->first();
        if (!$usermodelbranch) {
            return redirect()->back()->with('danger', __('app.gym.empty_model'));
        }
        $usermodel = $usermodelbranch->usermodel;
        $modelfeatures = json_decode($usermodel->features);
        foreach ($modelfeatures as $modelfeature) {
            if ($modelfeature == 9) {
                $screen = true;
            }
            if ($modelfeature == 10) {
                $notify = true;
            }
        }

        $lastsetting = $this->placesRepo->getUserShiftSettingByUserModel($usermodelbranchid);
        $modelrecords = $this->placesRepo->getNewData($usermodelbranch, null, null, $starttime, $endtime);
        $data = $modelrecords['data'] ?? [];
        $active_areas = $modelrecords['active_areas'] ?? [];
        $areas = $modelrecords['areas'] ?? [];

        $modelrecords['allsetting'] = PlaceMaintenanceSetting::where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'DESC')->get();

        $check = [];
        foreach ($areas as $area) {
            $check[] = $area['areabusydura'];
        }

        $charts = [];
        if (count(array_filter($check)) > 0) {
            $i = 0;
            foreach ($areas as $key => $value) {
                $charts['bar'][$i]['area'] = "Area #$key";
                $charts['bar'][$i]['work'] = $value['areabusydura'];
                $charts['bar'][$i]['empty'] = $value['areaavildura'];
                $i++;
            }

            $k = 0;
            foreach ($areas as $key => $value) {
                $charts['circle']['work'][$k]['area'] = "Area #$key";
                $charts['circle']['work'][$k]['value'] = $value['areabusydura'];
                $k++;
            }

            $j = 0;
            foreach ($areas as $key => $value) {
                $charts['circle']['empty'][$j]['area'] = "Area #$key";
                $charts['circle']['empty'][$j]['value'] = $value['areaavildura'];
                $j++;
            }
        }

        return view('customer.preview.branch.places', compact('charts', 'current_branch', 'activeRegions', 'starttime', 'endtime', 'areas', 'active_areas', 'branch_id', 'modelswithbranches', 'activebranches', 'screen', 'notify', 'usermodelbranchid', 'usermodelbranch', 'lastsetting', 'modelrecords', 'data', 'start', 'end'));
    }

    public function placesshiftSettingSave(Request $request, $branch_id, $usermodelbranchid)
    {
        $validator = Validator::make($request->all(), [
            'start_time' => 'required',
            'end_time' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('danger', $validator->errors()->first());
        }
        $activepackage = UserPackages::where('user_id', parentID())->where('active', '1')->first();
        $query = DB::table('user_model_branches')
            ->select(['user_model_branches.*', 'branches.id as b_id', 'branches.name as bname', 'models.name as mname', 'lt_models.id as lt_id'])
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->join('models', 'models.id', '=', 'users_models.model_id')
            ->join('lt_models', 'lt_models.id', '=', 'models.lt_model_id')
            ->where('users_models.user_package_id', $activepackage->id)
            ->where('branches.id', $branch_id);
        $count = $query->count();

        if ($count < 1) {
            return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
        }
        $usermodelbranch = UserModelBranch::find($usermodelbranchid);

        if (!$usermodelbranch) {
            return redirect()->back()->with('danger', __('app.gym.empty_model'));
        }

        return $this->placesRepo->shiftSettingSave($request, $usermodelbranchid);
    }

    public function placesfilter(Request $request, $branch_id, $usermodelbranchid)
    {

        $validator = Validator::make($request->all(), [
            'end' => 'required|date',
            'start' => 'required|date',
            'submittype' => 'required',
            'exportType' => 'required_if:submittype,2',
        ], [
            'exportType.required_if' => 'please select file format first',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('danger', $validator->errors()->first());
        }

        $activepackage = UserPackages::where('user_id', parentID())->where('active', '1')->first();
        $current_branch = Branch::findOrFail($branch_id);
        $activebranches = DB::table('user_model_branches')
            ->select(DB::raw('distinct(branches.id) as b_id, branches.name as bname'))
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->join('regions', 'regions.id', '=', 'branches.region_id')
            ->whereNull('user_model_branches.deleted_at')
            ->whereNull('branches.deleted_at')
            ->whereNull('regions.deleted_at')
            ->where('branches.region_id', $current_branch->region_id)
            ->where('branches.active', true)
            ->where('regions.active', true)
            ->whereNull('users_models.deleted_at')
            ->where('users_models.user_package_id', $activepackage->id)->distinct()->get();

        $activeRegions = Region::where('active', true)->where('user_id', parentID())->child()->get();

        $query = DB::table('user_model_branches')
            ->select(['user_model_branches.*', 'branches.id as b_id', 'branches.name as bname', 'models.name as mname', 'lt_models.id as lt_id'])
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->join('models', 'models.id', '=', 'users_models.model_id')
            ->join('lt_models', 'lt_models.id', '=', 'models.lt_model_id')
            ->join('regions', 'regions.id', '=', 'branches.region_id')
            ->whereNull('regions.deleted_at')
            ->where('branches.active', true)
            ->where('regions.active', true)
            ->where('users_models.user_package_id', $activepackage->id)
            ->whereNull('user_model_branches.deleted_at')
            ->whereNull('branches.deleted_at')
            ->whereNull('users_models.deleted_at')
            ->where('branches.id', $branch_id);

        $count = $query->count();
        $modelswithbranches = $query->get();
        if ($count < 1) {
            return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
        }
        $start = $request->start;
        $end = $request->end;
        $submittype = $request->submittype;
        $type = $request->exportType;
        $starttime = $request->starttime;
        $endtime = $request->endtime;
        $screen = false;
        $notify = false;
        $usermodelbranch = UserModelBranch::find($usermodelbranchid);
        $usermodel = $usermodelbranch->usermodel;
        $modelfeatures = json_decode($usermodel->features);
        foreach ($modelfeatures as $modelfeature) {
            if ($modelfeature == 9) {
                $screen = true;
            }
            if ($modelfeature == 10) {
                $notify = true;
            }
        }
        if (!$usermodelbranch) {
            return redirect()->back()->with('danger', __('app.gym.empty_model'));
        }
        $lastsetting = $this->placesRepo->getUserShiftSettingByUserModel($usermodelbranchid);

        $modelrecords = $this->placesRepo->getNewData($usermodelbranchid, $start, $end, $starttime, $endtime);
        $data = $modelrecords['data'] ?? [];
        $active_areas = $modelrecords['active_areas'] ?? [];
        $areas = $modelrecords['areas'] ?? [];
        $modelrecords['allsetting'] = PlaceMaintenanceSetting::where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'DESC')->get();


        if ($submittype == 2) {//for export

            $type = ($type == '1') ? 'pdf' : 'xls';

            $start_name = $start ?? 'first';
            $last_name = $end ?? 'last';
            $name = "{$current_branch->name}_file_from_{$start_name}_to_{$last_name}.$type";

            $file = BranchFiles::firstOrCreate([
                'start' => $start ?? null,
                'end' => $end ?? null,
                'user_model_branch_id' => $usermodelbranchid,
                'branch_id' => $branch_id,
                'type' => $type,
                'model_type' => 'place',
            ], [
                'name' => $name,
                'status' => false,
                'user_id' => auth()->id(),
            ]);

            if ($file->status && \Storage::disk('public')->exists($file->url)) {

                $headers = array(
                    "Content-Type: application/{$type}",
                );

                return redirect()->back()->with([
                    'success' => __('app.places.files_prepared_successfully'),
                    'branch_file' => Storage::disk('public')->url($file->url)
                ]);
            }

            return redirect()->back()->with('success', __('app.places.file_will_prepare_soon'));
        }

        $check = [];
        foreach ($areas as $area) {
            $check[] = $area['areabusydura'];
        }
        $charts = [];
        if (count(array_filter($check)) > 0) {

            $i = 0;
            foreach ($areas as $key => $value) {
                $charts['bar'][$i]['area'] = "Area #$key";
                $charts['bar'][$i]['work'] = $value['areabusydura'];
                $charts['bar'][$i]['empty'] = $value['areaavildura'];
                $i++;
            }

            $k = 0;
            foreach ($areas as $key => $value) {
                $charts['circle']['work'][$k]['area'] = "Area #$key";
                $charts['circle']['work'][$k]['value'] = $value['areabusydura'];
                $k++;
            }

            $j = 0;
            foreach ($areas as $key => $value) {
                $charts['circle']['empty'][$j]['area'] = "Area #$key";
                $charts['circle']['empty'][$j]['value'] = $value['areaavildura'];
                $j++;
            }
        }

        return view('customer.preview.branch.places', compact('charts', 'current_branch', 'activeRegions', 'starttime', 'endtime', 'areas', 'active_areas', 'branch_id', 'modelswithbranches', 'activebranches', 'screen', 'notify', 'usermodelbranchid', 'usermodelbranch', 'lastsetting', 'modelrecords', 'data', 'start', 'end'));

    }

    public function plates($branch_id, $usermodelbranchid)
    {

        $activepackage = UserPackages::where('user_id', parentID())->where('active', '1')->first();
        $user = Auth::user();
        $activebranches = [];
        $current_branch = Branch::findOrFail($branch_id);
        if ($user->type == "subcustomer") {
            $data = $user->branches;
            $branches = $data->pluck('id')->toArray();
            if (!in_array($branch_id, $branches)) {
                return redirect()->route('myBranches')->with('danger', __('app.gym.empty_branch'));
            }
            foreach ($data as $row) {
                $activebranches[] = (object)[
                    'bname' => $row->name,
                    'b_id' => $row->id,
                ];
            }


        } elseif ($user->type == "customer") {

            if ($current_branch->user_id != $user->id) {
                return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
            }

            $activebranches = DB::table('user_model_branches')
                ->select(DB::raw('distinct(branches.id) as b_id, branches.name as bname'))
                ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
                ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
                ->join('regions', 'regions.id', '=', 'branches.region_id')
                ->whereNull('user_model_branches.deleted_at')
                ->whereNull('branches.deleted_at')
                ->whereNull('regions.deleted_at')
                ->where('branches.region_id', $current_branch->region_id)
                ->where('branches.active', true)
                ->where('regions.active', true)
                ->whereNull('users_models.deleted_at')
                ->where('users_models.user_package_id', $activepackage->id)->distinct()->get();
        }


        $activeRegions = Region::where('active', true)->where('user_id', parentID())->child()->get();

        $query = DB::table('user_model_branches')
            ->select(['user_model_branches.*', 'branches.id as b_id', 'branches.name as bname', 'models.name as mname', 'lt_models.id as lt_id'])
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->join('models', 'models.id', '=', 'users_models.model_id')
            ->join('lt_models', 'lt_models.id', '=', 'models.lt_model_id')
            ->join('regions', 'regions.id', '=', 'branches.region_id')
            ->whereNull('regions.deleted_at')
            ->where('branches.active', true)
            ->where('regions.active', true)
            ->where('users_models.user_package_id', $activepackage->id)
            ->whereNull('user_model_branches.deleted_at')
            ->whereNull('branches.deleted_at')
            ->whereNull('users_models.deleted_at')
            ->where('branches.id', $branch_id);

        $count = $query->count();
        $modelswithbranches = $query->get();
        if ($count < 1) {
            return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
        }
        $start = null;
        $end = null;
        $starttime = null;
        $endtime = null;
        $screen = false;
        $notify = false;
        $usermodelbranch = UserModelBranch::find($usermodelbranchid);
        if (!$usermodelbranch) {
            return redirect()->back()->with('danger', __('app.gym.empty_model'));
        }
        $usermodel = $usermodelbranch->usermodel;
        $modelfeatures = json_decode($usermodel->features);
        foreach ($modelfeatures as $modelfeature) {
            if ($modelfeature == 11) {
                $screen = true;
            }
            if ($modelfeature == 12) {
                $notify = true;
            }
        }

        $lastsetting = $this->platesRepo->getUserShiftSettingByUserModel($usermodelbranchid);

        $records = $this->platesRepo->getNewData($branch_id, $start, $end);

        $areatimes = $records['areas_count'] ?? [];

        $data = $records['data'] ?? [];

        $modelrecords['allsetting'] = CarPLatesSetting::where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'DESC')->get();

        $charts = [];
        $i = 0;

        if (count(array_filter($areatimes)) > 0) {
            foreach ($areatimes as $key => $value) {
                $charts[$i]['area'] = "Area #$key";
                $charts[$i]['count'] = $value;
                $i++;
            }
        }
        $filter = ['show_by' => 'branch', 'branch_type' => 'branch', 'branch_data' => $current_branch->id];
        $invoice_chart = ReportService::handle('invoice', $filter);
        $duration_ratio = ReportService::handle('stayingAverage', $filter);
        $invoice_chart = $invoice_chart['charts']['bar'];
        $duration_ratio = round(array_sum(\Arr::pluck($duration_ratio['charts']['bar'],'value'))/3);

        return view('customer.preview.branch.plates', compact('invoice_chart', 'duration_ratio', 'charts', 'current_branch', 'activeRegions', 'starttime', 'endtime', 'areatimes', 'branch_id', 'modelswithbranches', 'activebranches', 'screen', 'notify', 'usermodelbranchid', 'usermodelbranch', 'lastsetting', 'modelrecords', 'data', 'start', 'end'));
    }

    public function platesshiftSettingSave(Request $request, $branch_id, $usermodelbranchid)
    {
        $validator = Validator::make($request->all(), [
            'start_time' => 'required',
            'end_time' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('danger', $validator->errors()->first());
        }
        $activepackage = UserPackages::where('user_id', parentID())->where('active', '1')->first();
        $activebranches = DB::table('user_model_branches')
            ->select(DB::raw('distinct(branches.id) as b_id, branches.name as bname'))
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->where('users_models.user_package_id', $activepackage->id)->distinct()->get();

        $query = DB::table('user_model_branches')
            ->select(['user_model_branches.*', 'branches.id as b_id', 'branches.name as bname', 'models.name as mname', 'lt_models.id as lt_id'])
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->join('models', 'models.id', '=', 'users_models.model_id')
            ->join('lt_models', 'lt_models.id', '=', 'models.lt_model_id')
            ->where('users_models.user_package_id', $activepackage->id)
            ->where('branches.id', $branch_id);
        $count = $query->count();
        $modelswithbranches = $query->get();
        if ($count < 1) {
            return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
        }
        $usermodelbranch = UserModelBranch::find($usermodelbranchid);

        if (!$usermodelbranch) {
            return redirect()->back()->with('danger', __('app.gym.empty_model'));
        }

        return $this->platesRepo->shiftSettingSave($request, $usermodelbranchid);
    }

    public function platesfilter(Request $request, $branch_id, $usermodelbranchid)
    {
        $usermodelbranch = UserModelBranch::find($usermodelbranchid);
        if (!$usermodelbranch) {
            return redirect()->back()->with('danger', __('app.gym.empty_model'));
        }
        $validator = Validator::make($request->all(), [
            'end' => 'required|date',
            'start' => 'required|date',
            'submittype' => 'required',
            'exportType' => 'required_if:submittype,2',
        ], [
            'exportType.required_if' => 'please select file format first',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('danger', $validator->errors()->first());
        }
        $activepackage = UserPackages::where('user_id', parentID())->where('active', '1')->first();

        $current_branch = Branch::findOrFail($branch_id);
        $activebranches = DB::table('user_model_branches')
            ->select(DB::raw('distinct(branches.id) as b_id, branches.name as bname'))
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->join('regions', 'regions.id', '=', 'branches.region_id')
            ->whereNull('user_model_branches.deleted_at')
            ->whereNull('branches.deleted_at')
            ->whereNull('regions.deleted_at')
            ->where('branches.region_id', $current_branch->region_id)
            ->where('branches.active', true)
            ->where('regions.active', true)
            ->whereNull('users_models.deleted_at')
            ->where('users_models.user_package_id', $activepackage->id)->distinct()->get();
        $activeRegions = Region::where('active', true)->where('user_id', parentID())->child()->get();

        $query = DB::table('user_model_branches')
            ->select(['user_model_branches.*', 'branches.id as b_id', 'branches.name as bname', 'models.name as mname', 'lt_models.id as lt_id'])
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->join('models', 'models.id', '=', 'users_models.model_id')
            ->join('lt_models', 'lt_models.id', '=', 'models.lt_model_id')
            ->join('regions', 'regions.id', '=', 'branches.region_id')
            ->whereNull('regions.deleted_at')
            ->where('branches.active', true)
            ->where('regions.active', true)
            ->where('users_models.user_package_id', $activepackage->id)
            ->whereNull('user_model_branches.deleted_at')
            ->whereNull('branches.deleted_at')
            ->whereNull('users_models.deleted_at')
            ->where('branches.id', $branch_id);

        $count = $query->count();
        $modelswithbranches = $query->get();
        if ($count < 1) {
            return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
        }

        $final_start = null;
        $final_end = null;
        $starttime = null;
        $endtime = null;
        $start = null;
        $end = null;

        if ($request->start and $request->end) {
            if ($request->starttime and $request->endtime) {
                $final_start = date('Y-m-d h:i:s', strtotime($request->start . ' ' . $request->starttime));
                $final_end = date('Y-m-d h:i:s', strtotime($request->end . ' ' . $request->endtime));
                $start = $request->start;
                $end = $request->end;
                $starttime = $request->starttime;
                $endtime = $request->endtime;
            } else {
                $final_start = date('Y-m-d h:i:s', strtotime($request->start));
                $final_end = date('Y-m-d h:i:s', strtotime($request->end));
                $starttime = null;
                $endtime = null;
                $start = $request->start ?? null;
                $end = $request->end ?? null;
            }
        }


        $submittype = $request->submittype;
        $type = $request->exportType;
        $screen = false;
        $notify = false;

        $usermodel = $usermodelbranch->usermodel;
        $modelfeatures = json_decode($usermodel->features);
        foreach ($modelfeatures as $modelfeature) {
            if ($modelfeature == 11) {
                $screen = true;
            }
            if ($modelfeature == 12) {
                $notify = true;
            }
        }

        $lastsetting = $this->platesRepo->getUserShiftSettingByUserModel($usermodelbranchid);

        $records = $this->platesRepo->getNewData($branch_id, $final_start, $final_end);

        $areatimes = $records['areas_count'] ?? [];

        $data = $records['data'] ?? [];

        $modelrecords['allsetting'] = CarPLatesSetting::where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'DESC')->get();

        if ($submittype == 2) {//for export

            $type = ($type == '1') ? 'pdf' : 'xls';

            $start_name = $start ?? 'first';
            $last_name = $end ?? 'last';
            $name = "{$current_branch->name}_file_from_{$start_name}_to_{$last_name}.$type";

            $file = BranchFiles::firstOrCreate([
                'start' => $start ?? null,
                'end' => $end ?? null,
                'user_model_branch_id' => $usermodelbranchid,
                'branch_id' => $branch_id,
                'type' => $type,
                'model_type' => 'plate',
            ], [
                'name' => $name,
                'status' => false,
                'user_id' => auth()->id(),
            ]);

            if ($file->status && Storage::disk('public')->exists($file->url)) {

                $headers = array(
                    "Content-Type: application/{$type}",
                );

                return redirect()->back()->with([
                    'success' => __('app.places.files_prepared_successfully'),
                    'branch_file' => Storage::disk('public')->url($file->url)
                ]);
            }
            $file->status = false;
            $file->save();

            return redirect()->back()->with('success', __('app.places.file_will_prepare_soon'));
        }

        $charts = [];
        $i = 0;
        if (count(array_filter($areatimes)) > 0) {
            foreach ($areatimes as $key => $value) {
                $charts[$i]['area'] = "Area #$key";
                $charts[$i]['count'] = $value;
                $i++;
            }
        }

        $invoice_chart = ReportService::invoiceComparisonReport('custom', [$current_branch->id], $start, $end);
        $duration_ratio = ReportService::stayingAverageComparisonReport('custom', [$current_branch->id], $start, $end);
        $duration_ratio = $duration_ratio[0]['duration'] ?? 0;

        return view('customer.preview.branch.plates', compact('invoice_chart', 'duration_ratio', 'charts', 'current_branch', 'activeRegions', 'starttime', 'endtime', 'areatimes', 'branch_id', 'modelswithbranches', 'activebranches', 'screen', 'notify', 'usermodelbranchid', 'usermodelbranch', 'lastsetting', 'modelrecords', 'data', 'start', 'end'));

    }

}
