<?php

namespace App\Http\Controllers\Models;

use App\Exports\PlacesExcelExport;
use App\Exports\RecieptionExcelExport;
use App\Http\Repositories\Eloquent\PlacesRepo;
use App\Models\AreaDuration;
use App\Models\AreaDurationDay;
use App\Models\AreaStatus;
use App\Models\Branch;
use App\Models\BranchFiles;
use App\Models\CarPLatesSetting;
use App\Models\Carprofile;
use App\Models\PlaceMaintenance;
use App\Models\PlaceMaintenanceSetting;
use App\Models\UserModel;
use App\Models\UserModelBranch;
use App\Http\Controllers\Controller;
use App\Models\UserPackages;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PDF;
use Excel;
use App\Exports\ExcelExport;

class PlacesController extends Controller
{
    protected $repo;

    public function __construct(PlacesRepo $repo)
    {
        $this->repo = $repo;
    }


    public function index($usermodelbranchid)
    {
        $user = Auth::user();

        $usermodelbranch = UserModelBranch::where('id', $usermodelbranchid)->with(['branch' => function ($q) {
            return $q->where('active', true);
        }])->first();

        if (!$usermodelbranch->branch) {
            return redirect()->route('myBranches')->with('danger', __('app.gym.empty_branch'));
        }

        if (!$usermodelbranch) {
            if ($user->type == "subcustomer") {
                return redirect()->route('myBranches')->with('danger', __('app.gym.empty_branch'));
            } else {
                return redirect()->route('customerPackages.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
            }
        }

        if ($user->type == "subcustomer") {
            $data = $user->branches;
            $branches = $data->pluck('id')->toArray();
            if (!in_array($usermodelbranch->branch_id, $branches)) {
                return redirect()->route('myBranches')->with('danger', __('app.gym.empty_branch'));
            }

        } elseif ($user->type == "customer") {
            $item = $usermodelbranch->branch;
            if ($item->user_id != $user->id) {
                return redirect()->route('customerPackages.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
            }
        }

        $activepackage = UserPackages::where('user_id', parentID())->where('active', '1')->first();
        $activebranches = DB::table('user_model_branches')
            ->select(DB::raw('distinct(branches.id)'))
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->whereNull('user_model_branches.deleted_at')
            ->whereNull('branches.deleted_at')
            ->whereNull('users_models.deleted_at')
            ->where('users_models.user_package_id', $activepackage->id)
            ->distinct()
            ->get();

        $brnarray = $activebranches->pluck('id')->toArray();
        $final_branches = [];

        $results = UserModelBranch::whereIn('branch_id', $brnarray)
            ->where('user_model_id', $usermodelbranch->user_model_id)
            ->with(['branch' => function ($q) {
                return $q->where('active', true);
            }])->get();

        if ($results->isNotEmpty()) {
            foreach ($results as $result) {
                $result = (object)$result;

                if ($result->branch)
                    $final_branches[] = [
                        'name' => $result->branch->name,
                        'user_model_branch_id' => $result->id
                    ];
            }
        }

        $start = null;
        $end = null;
        $starttime = null;
        $endtime = null;
        $screen = false;
        $notify = false;
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

        // here
        $lastsetting = $this->repo->getUserShiftSettingByUserModel($usermodelbranchid);
        $modelrecords = $this->repo->getNewData($usermodelbranchid, null, null, $starttime, $endtime);
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
                $charts['bar'][$i]['work'] = $value['areaavildura'];
                $charts['bar'][$i]['empty'] = $value['areabusydura'];
                $i++;
            }

            $k = 0;
            foreach ($areas as $key => $value) {
                $charts['circle']['work'][$k]['area'] = "Area #$key";
                $charts['circle']['work'][$k]['value'] = $value['areaavildura'];
                $k++;
            }

            $j = 0;
            foreach ($areas as $key => $value) {
                $charts['circle']['empty'][$j]['area'] = "Area #$key";
                $charts['circle']['empty'][$j]['value'] = $value['areabusydura'];
                $j++;
            }
        }

        return view('customer.preview.places.places', compact('charts', 'starttime', 'endtime', 'areas', 'active_areas', 'screen', 'notify', 'lastsetting', 'usermodelbranchid', 'usermodelbranch', 'modelrecords', 'data', 'start', 'end', 'final_branches'));
    }

    public function placesfilter(Request $request, $usermodelbranchid)
    {

        $validator = Validator::make($request->all(), [
            'end' => 'nullable|date',
            'start' => 'nullable|date',
            'submittype' => 'required',
            'exportType' => 'required_if:submittype,2',
        ], [
            'exportType.required_if' => 'please select file format first',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('danger', $validator->errors()->first());
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
        $lastsetting = $this->repo->getUserShiftSettingByUserModel($usermodelbranchid);
        $modelrecords = $this->repo->getNewData($usermodelbranchid, $start, $end, $starttime, $endtime);
        $data = $modelrecords['data'] ?? [];
        $active_areas = $modelrecords['active_areas'] ?? [];
        $areas = $modelrecords['areas'] ?? [];
        $modelrecords['allsetting'] = PlaceMaintenanceSetting::where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'DESC')->get();
        $current_branch = Branch::findOrFail($usermodelbranch->branch_id);

        $activepackage = UserPackages::where('user_id', parentID())->where('active', '1')->first();
        $activebranches = DB::table('user_model_branches')
            ->select(DB::raw('distinct(branches.id)'))
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->whereNull('user_model_branches.deleted_at')
            ->whereNull('branches.deleted_at')
            ->whereNull('users_models.deleted_at')
            ->where('users_models.user_package_id', $activepackage->id)
            ->distinct()
            ->get();

        $brnarray = $activebranches->pluck('id')->toArray();
        $final_branches = [];

        $results = UserModelBranch::whereIn('branch_id', $brnarray)
            ->where('user_model_id', $usermodelbranch->user_model_id)
            ->with(['branch' => function ($q) {
                return $q->where('active', true);
            }])->get();

        if ($results->isNotEmpty()) {
            foreach ($results as $result) {
                $final_branches[] = (object)[
                    'name' => $result->branch->name,
                    'user_model_branch_id' => $result->id
                ];
            }
        }

        if ($submittype == 2) {//for export

            $type = ($type == '1') ? 'pdf' : 'xls';

            $start_name = $start ?? 'first';
            $last_name = $end ?? 'last';
            $name = "{$current_branch->name}_file_from_{$start_name}_to_{$last_name}.$type";

            $file = BranchFiles::firstOrCreate([
                'start' => $start ?? null,
                'end' => $end ?? null,
                'user_model_branch_id' => $usermodelbranchid,
                'branch_id' => $current_branch->id,
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
                $charts['bar'][$i]['work'] = $value['areaavildura'];
                $charts['bar'][$i]['empty'] = $value['areabusydura'];
                $i++;
            }

            $k = 0;
            foreach ($areas as $key => $value) {
                $charts['circle']['work'][$k]['area'] = "Area #$key";
                $charts['circle']['work'][$k]['value'] = $value['areaavildura'];
                $k++;
            }

            $j = 0;
            foreach ($areas as $key => $value) {
                $charts['circle']['empty'][$j]['area'] = "Area #$key";
                $charts['circle']['empty'][$j]['value'] = $value['areabusydura'];
                $j++;
            }
        }
        return view('customer.preview.places.places', compact('final_branches', 'charts', 'starttime', 'endtime', 'areas', 'active_areas', 'screen', 'notify', 'lastsetting', 'usermodelbranchid', 'usermodelbranch', 'modelrecords', 'data', 'start', 'end'));
    }

    public function placesshiftSettingSave(Request $request, $usermodelbranchid)
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
        $found = false;
        $usermodelbranch = UserModelBranch::find($usermodelbranchid);

        if (!$usermodelbranch) {
            return redirect()->back()->with('danger', __('app.gym.empty_model'));
        }

        return $this->repo->shiftSettingSave($request, $usermodelbranchid);
    }

    public function get_branch_data(Request $request)
    {

        if ($request->date == 'all') {
            $query = AreaDuration::where('branch_id', $request->branch_id)->where('area', $request->area);
            $data = $query->select('area',
                DB::raw('SUM(work_by_minute) as work_by_minute'),
                DB::raw('SUM(empty_by_minute) as empty_by_minute')
            )->first();

        } else {

            $date = getStartEndDate($request->date);
            $start = $date['start'];
            $end = $date['end'];

            if ($start == $end) {

                $areabusydura = 0;
                $areaavildura = 0;

                Carprofile::where('branch_id', $request->branch_id)
                    ->where('BayCode',  $request->area)
                    ->where('status', 'completed')
                    ->whereDate('checkInDate', $start)
                    ->chunk(500, function ($profiles) use (&$areabusydura) {
                        foreach ($profiles as $record) {
                            $start = Carbon::parse($record->checkInDate);
                            $end = Carbon::parse($record->checkOutDate);
                            if ($end > $start) {
                                $difference = $end->diffInMinutes($start);
                                $areabusydura += $difference;
                            }
                        }
                    });

                $UserModelBranch = UserModelBranch::with('branch')->where('branch_id',$request->branch_id)->latest()->first();

                $branch_work = PlaceMaintenanceSetting::where('user_model_branch_id', $UserModelBranch->id)->where('active', 1)->first();
                if (!$branch_work) {
                    $branch_work = CarPLatesSetting::where('user_model_branch_id', $UserModelBranch->id)->where('active', 1)->first();
                }
                if ($branch_work) {
                    $start = Carbon::parse($branch_work->start_time);
                    $end = Carbon::now();
                    if ($end > $start) {
                        $branch_work_time_in_minutes = $end->diffInMinutes($start);
                        $result = 0;
                        if ($branch_work_time_in_minutes > $areabusydura) {
                            $result = $branch_work_time_in_minutes - $areabusydura;
                        }
                        $areaavildura = $result;
                    }
                }

                return (object)[
                    'area' => $request->area,
                    'work_by_minute' =>$areabusydura,
                    'empty_by_minute' => $areaavildura,
                ];
            } else {
                $query = AreaDurationDay::where('branch_id', $request->branch_id)->where('area', $request->area);

                if ($start) {
                    $query = $query->whereDate('date', '>=', $start);
                }
                if ($end) {
                    $query = $query->whereDate('date', '<=', $end);
                }
                $data = $query->select('area',
                    DB::raw('SUM(work_by_minute) as work_by_minute'),
                    DB::raw('SUM(empty_by_minute) as empty_by_minute')
                )->first();
            }

        }


        return response()->json(['data' => $data]);
    }

}
