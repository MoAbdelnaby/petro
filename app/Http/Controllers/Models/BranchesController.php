<?php

namespace App\Http\Controllers\Models;

use App\Exports\CarsExcelExport;
use App\Exports\EmotionExcelExport;
use App\Exports\ExcelExport;
use App\Exports\MaskExcelExport;
use App\Exports\PlacesExcelExport;
use App\Exports\PlatesExcelExport;
use App\Exports\RecieptionExcelExport;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\CarRepo;
use App\Http\Repositories\Eloquent\DoorRepo;
use App\Http\Repositories\Eloquent\EmotionRepo;
use App\Http\Repositories\Eloquent\MaskRepo;
use App\Http\Repositories\Eloquent\PeopleCountRepo;
use App\Http\Repositories\Eloquent\PlacesRepo;
use App\Http\Repositories\Eloquent\PlatesRepo;
use App\Http\Repositories\Eloquent\RecieptionRepo;
use App\Models\AreaStatus;
use App\Models\Branch;
use App\Models\BranchFiles;
use App\Models\CarPLatesSetting;
use App\Models\CarSetting;
use App\Models\DoorRecieptionSetting;
use App\Models\EmotionSetting;
use App\Models\Heatmap;
use App\Models\Image;
use App\Models\MaskSetting;
use App\Models\PeopleSetting;
use App\Models\PlaceMaintenance;
use App\Models\PlaceMaintenanceSetting;
use App\Models\RecieptionSetting;
use App\Models\Region;
use App\Models\UserModelBranch;
use App\Models\UserPackages;
use App\UserSetting;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PDF;

class BranchesController extends Controller
{
    protected $doorrepo;
    protected $recieptionrepo;
    protected $peopleCountRepo;
    protected $placesRepo;
    protected $platesRepo;
    protected $maskRepo;
    protected $emotionRepo;
    protected $carRepo;

    public function __construct(DoorRepo $doorrepo, RecieptionRepo $recieptionrepo, PeopleCountRepo $peopleCountRepo,
                                PlacesRepo $placesRepo, PlatesRepo $platesRepo, MaskRepo $maskRepo, CarRepo $carRepo, EmotionRepo $emotionRepo)
    {
        $this->doorrepo = $doorrepo;
        $this->recieptionrepo = $recieptionrepo;
        $this->peopleCountRepo = $peopleCountRepo;
        $this->placesRepo = $placesRepo;
        $this->platesRepo = $platesRepo;
        $this->maskRepo = $maskRepo;
        $this->emotionRepo = $emotionRepo;
        $this->carRepo = $carRepo;
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
                if ($items[0]->lt_id == 1) {
                    return redirect()->route('branchmodelpreview.door', [$branch_id, $items[0]->id]);
                } else if ($items[0]->lt_id == 2) {
                    return redirect()->route('branchmodelpreview.recieption', [$branch_id, $items[0]->id]);
                } else if ($items[0]->lt_id == 3) {
                    return redirect()->route('branchmodelpreview.people', [$branch_id, $items[0]->id]);
                } else if ($items[0]->lt_id == 4) {
                    return redirect()->route('branchmodelpreview.car', [$branch_id, $items[0]->id]);
                } else if ($items[0]->lt_id == 5) {
                    return redirect()->route('branchmodelpreview.emotion', [$branch_id, $items[0]->id]);
                } else if ($items[0]->lt_id == 6) {
                    return redirect()->route('branchmodelpreview.mask', [$branch_id, $items[0]->id]);
                } else if ($items[0]->lt_id == 7) {
                    return redirect()->route('branchmodelpreview.heatmap', [$branch_id, $items[0]->id]);
                } else if ($items[0]->lt_id == 8) {
                    return redirect()->route('branchmodelpreview.places', [$branch_id, $items[0]->id]);
                } else if ($items[0]->lt_id == 9) {
                    return redirect()->route('branchmodelpreview.plates', [$branch_id, $items[0]->id]);
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
                    if ($items[0]->lt_id == 1) {
                        return redirect()->route('branchmodelpreview.door', [$branch_id, $items[0]->id]);
                    } else if ($items[0]->lt_id == 2) {
                        return redirect()->route('branchmodelpreview.recieption', [$branch_id, $items[0]->id]);
                    } else if ($items[0]->lt_id == 3) {
                        return redirect()->route('branchmodelpreview.people', [$branch_id, $items[0]->id]);
                    } else if ($items[0]->lt_id == 4) {
                        return redirect()->route('branchmodelpreview.car', [$branch_id, $items[0]->id]);
                    } else if ($items[0]->lt_id == 5) {
                        return redirect()->route('branchmodelpreview.emotion', [$branch_id, $items[0]->id]);
                    } else if ($items[0]->lt_id == 6) {
                        return redirect()->route('branchmodelpreview.mask', [$branch_id, $items[0]->id]);
                    } else if ($items[0]->lt_id == 7) {
                        return redirect()->route('branchmodelpreview.heatmap', [$branch_id, $items[0]->id]);
                    } else if ($items[0]->lt_id == 8) {
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

    public function recieption($branch_id, $usermodelbranchid)
    {
        $activepackage = UserPackages::where('user_id', parentID())->where('active', '1')->first();
        $user = Auth::user();
        $activebranches = [];
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
            $item = Branch::findOrFail($branch_id);
            if ($item->user_id != $user->id) {
                return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
            }
            $activebranches = DB::table('user_model_branches')
                ->select(DB::raw('distinct(branches.id) as b_id, branches.name as bname'))
                ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
                ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
                ->whereNull('user_model_branches.deleted_at')
                ->whereNull('branches.deleted_at')
                ->whereNull('users_models.deleted_at')
                ->where('users_models.user_package_id', $activepackage->id)->distinct()->get();
        }

        $query = DB::table('user_model_branches')
            ->select(['user_model_branches.*', 'branches.id as b_id', 'branches.name as bname', 'models.name as mname', 'lt_models.id as lt_id'])
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->join('models', 'models.id', '=', 'users_models.model_id')
            ->join('lt_models', 'lt_models.id', '=', 'models.lt_model_id')
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
            if ($modelfeature == 3) {
                $screen = true;
            }
            if ($modelfeature == 4) {
                $notify = true;
            }
        }

        $lastsetting = $this->recieptionrepo->getUserShiftSettingByUserModel($usermodelbranchid);

        $modelrecords = $this->recieptionrepo->getRecordsByUserModelId($usermodelbranchid, null, null, $starttime, $endtime);
        $timeempty = 0;
        $timeone = 0;
        $timetwo = 0;
        $perempty = '0';
        $perone = '0';
        $pertwo = '0';
        $i = 0;
        foreach ($modelrecords['list'] as $item) {
            if ($i > 0) {

                if ($modelrecords['list'][$i - 1]->date == $item->date) {
                    $time1 = strtotime($modelrecords['list'][$i - 1]->time);
                    $time2 = strtotime($item->time);
                    $difference = round(abs($time2 - $time1) / 60); // in minutes
                    if ($modelrecords['list'][$i - 1]->count == 0) { //it was empty
                        $timeempty += $difference;
                    } else if ($modelrecords['list'][$i - 1]->count == $lastsetting->min_persons) {  //it was one person
                        $timeone += $difference;
                    } else if ($modelrecords['list'][$i - 1]->count == $lastsetting->max_persons) {//it was two person
                        $timetwo += $difference;
                    } else {
                    }
                }
            }
            $i++;

        }
        if ($timeempty < 60) { //by minutes
            $perempty = '0';
        } else {//by hours
            $timeempty = round($timeempty / 60);
            $perempty = '1';
        }

        if ($timeone < 60) { //by minutes
            $perone = '0';
        } else {//by hours
            $timeone = round($timeone / 60);
            $perone = '1';
        }

        if ($timetwo < 60) { //by minutes
            $pertwo = '0';
        } else {//by hours
            $timetwo = round($timetwo / 60);
            $pertwo = '1';
        }
        $data = $modelrecords['data'];
        $modelrecords['allsetting'] = RecieptionSetting::where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'DESC')->get();
        return view('customer.preview.branch.receiption', compact('starttime', 'endtime', 'branch_id', 'modelswithbranches', 'activebranches', 'screen', 'notify', 'usermodelbranchid', 'usermodelbranch', 'lastsetting', 'modelrecords', 'data', 'timeempty', 'timetwo', 'timeone', 'start', 'end', 'perempty', 'perone', 'pertwo'));
    }

    public function recieptionfilter(Request $request, $branch_id, $usermodelbranchid)
    {
        $validator = Validator::make($request->all(), [
            'end' => 'nullable|date',
            'start' => 'nullable|date',
            'submittype' => 'required',
            'exportType' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('danger', $validator->errors()->first());
        }
        $activepackage = UserPackages::where('user_id', parentID())->where('active', '1')->first();
        $activebranches = DB::table('user_model_branches')
            ->select(DB::raw('distinct(branches.id) as b_id, branches.name as bname'))
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->where('users_models.user_package_id', $activepackage->id)->get();

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
            if ($modelfeature == 3) {
                $screen = true;
            }
            if ($modelfeature == 4) {
                $notify = true;
            }
        }
        if (!$usermodelbranch) {
            return redirect()->back()->with('danger', __('app.gym.empty_model'));
        }
        $lastsetting = $this->recieptionrepo->getUserShiftSettingByUserModel($usermodelbranchid);

        $modelrecords = $this->recieptionrepo->getRecordsByUserModelId($usermodelbranchid, $start, $end, $starttime, $endtime);
        $timeempty = 0;
        $timeone = 0;
        $timetwo = 0;
        $perempty = '0';
        $perone = '0';
        $pertwo = '0';
        $i = 0;
        foreach ($modelrecords['list'] as $item) {

            if ($i > 0) {

                if ($modelrecords['list'][$i - 1]->date == $item->date) {
                    $time1 = strtotime($modelrecords['list'][$i - 1]->time);
                    $time2 = strtotime($item->time);
                    $difference = round(abs($time2 - $time1) / 60); // in minutes
                    if ($modelrecords['list'][$i - 1]->count == 0) { //it was empty
                        $timeempty += $difference;
                    } else if ($modelrecords['list'][$i - 1]->count == $lastsetting->min_persons) {  //it was one person
                        $timeone += $difference;
                    } else if ($modelrecords['list'][$i - 1]->count == $lastsetting->max_persons) {  //it was one person
                        $timetwo += $difference;
                    } else { //it was two person
//                        $timetwo+=$difference;
                    }
                }
            }

            $i++;

        }
        if ($timeempty < 60) { //by minutes
            $perempty = '0';
        } else {//by hours
            $timeempty = round($timeempty / 60);
            $perempty = '1';
        }

        if ($timeone < 60) { //by minutes
            $perone = '0';
        } else {//by hours
            $timeone = round($timeone / 60);
            $perone = '1';
        }

        if ($timetwo < 60) { //by minutes
            $pertwo = '0';
        } else {//by hours
            $timetwo = round($timetwo / 60);
            $pertwo = '1';
        }

        $data = $modelrecords['data'];
        if ($submittype == 2) {   //for export
            if ($type == 1) {  //type pdf
                $modelrecordsfilter = $this->recieptionrepo->getRecordsByUserModelIdexport($usermodelbranchid, $start, $end, $starttime, $endtime);

                $usermcount = [];
                $uservalcount = [];
                $emptychartArr = [];
                $onechartArr = [];
                $twochartArr = [];

                foreach ($modelrecordsfilter['list'] as $key => $value) {
                    $usermcount[(int)$key] = count($value);
                    $uservalcount[(int)$key] = $value;
                }
                // dd($uservalcount);
                for ($i = 1; $i <= 12; $i++) {
                    if (!empty($usermcount[$i])) {
                        $emptychartArr[$i] = 0;
                        $onechartArr[$i] = 0;
                        $twochartArr[$i] = 0;
                        foreach ($uservalcount[$i] as $key => $value) {
                            if ($value->count == 0) {
                                $emptychartArr[$i] += 1;
                            } else if ($value->count == $lastsetting->min_persons) {
                                $onechartArr[$i] += 1;
                            } else if ($value->count == $lastsetting->max_persons) {
                                $twochartArr[$i] += 1;
                            } else {
//                                $twochartArr[$i] +=1;
                            }
                        }

                    } else {
                        $emptychartArr[$i] = 0;
                        $onechartArr[$i] = 0;
                        $twochartArr[$i] = 0;
                    }
                }

                $chrt["type"] = "bar";
                $chrt["data"]["labels"] = [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "jun",
                    "jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec"
                ];
                $chrt["data"]["datasets"][0]["label"] = "Total Empty";
                $chrt["data"]["datasets"][0]["backgroundColor"] = "blue";
                $chrt["data"]["datasets"][0]["data"] = array_values($emptychartArr);


                $chrt["data"]["datasets"][1]["label"] = "Total Min Person";
                $chrt["data"]["datasets"][1]["backgroundColor"] = "orange";
                $chrt["data"]["datasets"][1]["data"] = array_values($onechartArr);

                $chrt["data"]["datasets"][2]["label"] = "Total Max Person";
                $chrt["data"]["datasets"][2]["backgroundColor"] = "green";
                $chrt["data"]["datasets"][2]["data"] = array_values($twochartArr);
                $allchrt = urlencode(\json_encode($chrt));


                view()->share('data', $list);
                $pdf = PDF::loadView('customer.preview.recieption.recieptionpdf', compact('list', 'allchrt'));
                return $pdf->download('recieptionRecords.pdf');
            } else {
                return Excel::download(new RecieptionExcelExport($list), 'recieption_data.xlsx');

            }
        }

        $modelrecords['allsetting'] = RecieptionSetting::where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'DESC')->get();
        return view('customer.preview.branch.receiption', compact('starttime', 'endtime', 'branch_id', 'modelswithbranches', 'activebranches', 'screen', 'notify', 'usermodelbranchid', 'usermodelbranch', 'lastsetting', 'modelrecords', 'data', 'timeempty', 'timetwo', 'timeone', 'start', 'end', 'perempty', 'perone', 'pertwo'));
    }

    public function recieptionshiftSettingSave(Request $request, $branch_id, $usermodelbranchid)
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

        return $this->recieptionrepo->shiftSettingSave($request, $usermodelbranchid);
    }

    public function door($branch_id, $usermodelbranchid)
    {
        $activepackage = UserPackages::where('user_id', parentID())->where('active', '1')->first();
        $user = Auth::user();
        $activebranches = [];
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
            $item = Branch::findOrFail($branch_id);
            if ($item->user_id != $user->id) {
                return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
            }
            $activebranches = DB::table('user_model_branches')
                ->select(DB::raw('distinct(branches.id) as b_id, branches.name as bname'))
                ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
                ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
                ->whereNull('user_model_branches.deleted_at')
                ->whereNull('branches.deleted_at')
                ->whereNull('users_models.deleted_at')
                ->where('users_models.user_package_id', $activepackage->id)->distinct()->get();
        }

        $query = DB::table('user_model_branches')
            ->select(['user_model_branches.*', 'branches.id as b_id', 'branches.name as bname', 'models.name as mname', 'lt_models.id as lt_id'])
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->join('models', 'models.id', '=', 'users_models.model_id')
            ->join('lt_models', 'lt_models.id', '=', 'models.lt_model_id')
            ->whereNull('user_model_branches.deleted_at')
            ->whereNull('branches.deleted_at')
            ->whereNull('users_models.deleted_at')
            ->where('users_models.user_package_id', $activepackage->id)
            ->where('branches.id', $branch_id);
        $count = $query->count();
        $modelswithbranches = $query->get();
        if ($count < 1) {
            return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
        }
        $starttime = null;
        $endtime = null;
        $start = null;
        $end = null;
        $screen = false;
        $notify = false;
        $usermodelbranch = UserModelBranch::find($usermodelbranchid);
        if (!$usermodelbranch) {
            return redirect()->back()->with('danger', __('app.gym.empty_model'));
        }
        $usermodel = $usermodelbranch->usermodel;
        $modelfeatures = json_decode($usermodel->features);
        foreach ($modelfeatures as $modelfeature) {
            if ($modelfeature == 1) {
                $screen = true;
            }
            if ($modelfeature == 2) {
                $notify = true;
            }
        }

        $lastsetting = $this->doorrepo->getUserShiftSettingByUserModel($usermodelbranchid);

        $modelrecords = $this->doorrepo->getRecordsByUserModelId($usermodelbranchid, null, null, $starttime, $endtime);
        $timeopened = $modelrecords['count'] * 10;
        $totalclosed = 0;
        $per = '0';
        if ($timeopened < 60) { //by seconds
            $per = '0';
        } else if ($timeopened < 3600) {//by minutes
            $timeopened = round($timeopened / 60);
            $per = '1';
        } else {//by hours
            $timeopened = round($timeopened / 3600);
            $per = '2';
        }
        foreach ($modelrecords['list'] as $item) {
            //dd($modelrecords);
            $time1 = strtotime($item->shift_setting->start_time);
            $time2 = strtotime($item->shift_setting->end_time);
            $difference = round(abs($time2 - $time1) / 3600, 2);
            $totalclosed += $difference;

        }
        $totalclosed = round($totalclosed) - round(($modelrecords['count'] * 10) / 3600);
        $data = $modelrecords['data'];
        $modelrecords['allsetting'] = DoorRecieptionSetting::where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'DESC')->get();
        return view('customer.preview.branch.door', compact('starttime', 'endtime', 'branch_id', 'modelswithbranches', 'activebranches', 'screen', 'notify', 'usermodelbranchid', 'usermodelbranch', 'lastsetting', 'modelrecords', 'data', 'timeopened', 'per', 'totalclosed', 'start', 'end'));
    }

    public function doorfilter(Request $request, $branch_id, $usermodelbranchid)
    {

        $validator = Validator::make($request->all(), [
            'end' => 'nullable|date',
            'start' => 'nullable|date',
            'submittype' => 'required',
            'exportType' => 'required',
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
        $start = $request->start;
        $end = $request->end;
        $starttime = $request->starttime;
        $endtime = $request->endtime;
        $submittype = $request->submittype;
        $type = $request->exportType;
        $screen = false;
        $notify = false;
        $usermodelbranch = UserModelBranch::find($usermodelbranchid);
        $usermodel = $usermodelbranch->usermodel;
        $modelfeatures = json_decode($usermodel->features);
        foreach ($modelfeatures as $modelfeature) {
            if ($modelfeature == 1) {
                $screen = true;
            }
            if ($modelfeature == 2) {
                $notify = true;
            }
        }
        if (!$usermodelbranch) {
            return redirect()->back()->with('danger', __('app.gym.empty_model'));
        }
        $lastsetting = $this->doorrepo->getUserShiftSettingByUserModel($usermodelbranchid);

        $modelrecords = $this->doorrepo->getRecordsByUserModelId($usermodelbranchid, $start, $end, $starttime, $endtime);
        $timeopened = $modelrecords['count'] * 10;
        $totalclosed = 0;
        $per = '0';
        if ($timeopened < 60) { //by seconds
            $per = '0';
        } else if ($timeopened < 3600) {//by minutes
            $timeopened = round($timeopened / 60);
            $per = '1';
        } else {//by hours
            $timeopened = round($timeopened / 3600);
            $per = '2';
        }
        foreach ($modelrecords['list'] as $item) {


            $time1 = strtotime($item->shift_setting->start_time);
            $time2 = strtotime($item->shift_setting->end_time);
            $difference = round(abs($time2 - $time1) / 3600, 2);
            $totalclosed += $difference;


        }
        $totalclosed = round($totalclosed) - round(($modelrecords['count'] * 10) / 3600);
        $data = $modelrecords['data'];
        $list = $modelrecords['list'];
        if ($submittype == 2) {   //for export
            if ($type == 1) {  //type pdf
                //doooooooooooooooor data grouping
                $modelrecordsfilter = $this->doorrepo->getRecordsByUserModelIdexport($usermodelbranchid, $start, $end, $starttime, $endtime);


                $usermcount = [];
                $OpendurationArr = [];
                $OpentimeArr = [];

                foreach ($modelrecordsfilter['list'] as $key => $value) {
                    $usermcount[(int)$key] = count($value);
                }

                for ($i = 1; $i <= 12; $i++) {
                    if (!empty($usermcount[$i])) {
                        $OpentimeArr[$i] = $usermcount[$i];
                        $OpendurationArr[$i] = $usermcount[$i] * 10;
                    } else {
                        $OpendurationArr[$i] = 0;
                        $OpentimeArr[$i] = 0;
                    }
                }


                $opendoorchrt["type"] = "bar";
                $opendoorchrt["data"]["labels"] = [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "jun",
                    "jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec"
                ];
                $opendoorchrt["data"]["datasets"][0]["label"] = "Total door opened";
                $opendoorchrt["data"]["datasets"][0]["backgroundColor"] = "blue";
                $opendoorchrt["data"]["datasets"][0]["data"] = array_values($OpentimeArr);

                $opendoorc = urlencode(\json_encode($opendoorchrt));


                ////////////////////////////////////////time chart
                $opendoordurationchrt["type"] = "bar";
                $opendoordurationchrt["data"]["labels"] = [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "jun",
                    "jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec"
                ];
                $opendoordurationchrt["data"]["datasets"][0]["label"] = "Duration door opened";
                $opendoordurationchrt["data"]["datasets"][0]["backgroundColor"] = "green";
                $opendoordurationchrt["data"]["datasets"][0]["data"] = array_values($OpendurationArr);

                $opendoordurationc = urlencode(\json_encode($opendoordurationchrt));
                //////////////////////////////////////////////////
                view()->share('data', $list);
                $pdf = PDF::loadView('customer.preview.door.doorpdf', compact(['list', 'opendoorc', 'opendoordurationc']));
                return $pdf->download('doorRecords.pdf');

            } else {
                return Excel::download(new ExcelExport($list), 'door_data.xlsx');

            }
        }
        $modelrecords['allsetting'] = DoorRecieptionSetting::where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'DESC')->get();
        return view('customer.preview.door.door', compact('starttime', 'endtime', 'branch_id', 'modelswithbranches', 'activebranches', 'screen', 'notify', 'usermodelbranchid', 'usermodelbranch', 'lastsetting', 'modelrecords', 'data', 'timeopened', 'per', 'totalclosed', 'start', 'end'));

    }

    public function doorshiftSettingSave(Request $request, $branch_id, $usermodelbranchid)
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

        return $this->doorrepo->shiftSettingSave($request, $usermodelbranchid);
    }

    public function people($branch_id, $usermodelbranchid)
    {
        $activepackage = UserPackages::where('user_id', parentID())->where('active', '1')->first();
        $user = Auth::user();
        $activebranches = [];
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
            $item = Branch::findOrFail($branch_id);
            if ($item->user_id != $user->id) {
                return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
            }
            $activebranches = DB::table('user_model_branches')
                ->select(DB::raw('distinct(branches.id) as b_id, branches.name as bname'))
                ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
                ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
                ->whereNull('user_model_branches.deleted_at')
                ->whereNull('branches.deleted_at')
                ->whereNull('users_models.deleted_at')
                ->where('users_models.user_package_id', $activepackage->id)->distinct()->get();
        }


        $query = DB::table('user_model_branches')
            ->select(['user_model_branches.*', 'branches.id as b_id', 'branches.name as bname', 'models.name as mname', 'lt_models.id as lt_id'])
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->join('models', 'models.id', '=', 'users_models.model_id')
            ->join('lt_models', 'lt_models.id', '=', 'models.lt_model_id')
            ->whereNull('user_model_branches.deleted_at')
            ->whereNull('branches.deleted_at')
            ->whereNull('users_models.deleted_at')
            ->where('users_models.user_package_id', $activepackage->id)
            ->where('branches.id', $branch_id);

        $count = $query->count();

        $modelswithbranches = $query->get();
//        dd($modelswithbranches);

        if ($count < 1) {
            return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
        }
        $start = null;
        $end = null;
        $starttime = null;
        $endtime = null;
        $year = 'all';
        $month = 'all';
        $screen = false;
        $notify = false;
        $usermodelbranch = UserModelBranch::find($usermodelbranchid);
        if (!$usermodelbranch) {
            return redirect()->back()->with('danger', __('app.gym.empty_model'));
        }
        $usermodel = $usermodelbranch->usermodel;
        $modelfeatures = json_decode($usermodel->features);

        foreach ($modelfeatures as $modelfeature) {
            if ($modelfeature == 5) {
                $screen = true;
            }
            if ($modelfeature == 6) {
                $notify = true;
            }
        }


        $lastsetting = $this->peopleCountRepo->getUserShiftSettingByUserModel($usermodelbranchid);
        $statisticdata = $this->peopleCountRepo->getStatisticsByUserModelId($usermodelbranchid, null, null, $year, $month, $starttime, $endtime);
        $modelrecords = $this->peopleCountRepo->getRecordsByUserModelId($usermodelbranchid, null, null, $starttime, $endtime);

        $data = $modelrecords['data'];
        $modelrecords['allsetting'] = PeopleSetting::where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'DESC')->get();
        return view('customer.preview.branch.people', compact('starttime', 'endtime', 'year', 'month', 'statisticdata', 'branch_id', 'modelswithbranches', 'activebranches', 'screen', 'notify', 'lastsetting', 'usermodelbranchid', 'usermodelbranch', 'modelrecords', 'data', 'start', 'end'));
    }

    public function peoplefilter(Request $request, $branch_id, $usermodelbranchid)
    {

        $validator = Validator::make($request->all(), [
            'end' => 'nullable|date',
            'start' => 'nullable|date',
//            'year' => 'required',
//            'month' => 'required',
            'submittype' => 'required',
            'exportType' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('danger', $validator->errors()->first());
        }
//        dd($request->all());
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
        $start = $request->start;
        $end = $request->end;
        $starttime = $request->starttime;
        $endtime = $request->endtime;
        $year = null;
        $month = null;
        $submittype = $request->submittype;
        $type = $request->exportType;
        $screen = false;
        $notify = false;
        $usermodelbranch = UserModelBranch::find($usermodelbranchid);
        $usermodel = $usermodelbranch->usermodel;
        $modelfeatures = json_decode($usermodel->features);
        foreach ($modelfeatures as $modelfeature) {
            if ($modelfeature == 5) {
                $screen = true;
            }
            if ($modelfeature == 6) {
                $notify = true;
            }
        }
        if (!$usermodelbranch) {
            return redirect()->back()->with('danger', __('app.gym.empty_model'));
        }
        $lastsetting = $this->peopleCountRepo->getUserShiftSettingByUserModel($usermodelbranchid);
        $statisticdata = $this->peopleCountRepo->getStatisticsByUserModelId($usermodelbranchid, null, null, $year, $month, $starttime, $endtime);
        $modelrecords = $this->peopleCountRepo->getRecordsByUserModelId($usermodelbranchid, null, null, $starttime, $endtime);

        $data = $modelrecords['data'];
        $modelrecords['allsetting'] = PeopleSetting::where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'DESC')->get();


        $list = $modelrecords['list'];
        if ($submittype == 2) {   //for export
            if ($type == 1) {  //type pdf

                view()->share('data', $list);
                $pdf = PDF::loadView('customer.preview.people.peoplepdf', compact(['list']));
                return $pdf->download('peopleRecords.pdf');

            } else {
                return Excel::download(new RecieptionExcelExport($list), 'people_data.xlsx');

            }
        }
        $modelrecords['allsetting'] = DoorRecieptionSetting::where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'DESC')->get();
        return view('customer.preview.branch.people', compact('starttime', 'endtime', 'year', 'month', 'statisticdata', 'branch_id', 'modelswithbranches', 'activebranches', 'screen', 'notify', 'lastsetting', 'usermodelbranchid', 'usermodelbranch', 'modelrecords', 'data', 'start', 'end'));

    }

    public function peopleshiftSettingSave(Request $request, $branch_id, $usermodelbranchid)
    {
        $validator = Validator::make($request->all(), [
            'start_time' => 'required',
            'end_time' => 'required',
            'saving_interval' => 'required|numeric',
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

        return $this->peopleCountRepo->shiftSettingSave($request, $usermodelbranchid);
    }

    public function heatmap($branch_id, $usermodelbranchid, $cameraid = 1)
    {
        $activepackage = UserPackages::where('user_id', parentID())->where('active', '1')->first();
        $user = Auth::user();
        $activebranches = [];
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
            $item = Branch::findOrFail($branch_id);
            if ($item->user_id != $user->id) {
                return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
            }
            $activebranches = DB::table('user_model_branches')
                ->select(DB::raw('distinct(branches.id) as b_id, branches.name as bname'))
                ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
                ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
                ->whereNull('user_model_branches.deleted_at')
                ->whereNull('branches.deleted_at')
                ->whereNull('users_models.deleted_at')
                ->where('users_models.user_package_id', $activepackage->id)->distinct()->get();
        }


        $query = DB::table('user_model_branches')
            ->select(['user_model_branches.*', 'branches.id as b_id', 'branches.name as bname', 'models.name as mname', 'lt_models.id as lt_id'])
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->join('models', 'models.id', '=', 'users_models.model_id')
            ->join('lt_models', 'lt_models.id', '=', 'models.lt_model_id')
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

//        $usermodelbranch = UserModelBranch::find($usermodelbranchid);
//
//        if(!$usermodelbranch){
//            return redirect()->back()->with('danger',__('app.gym.empty_model'));
//        }

        $usermodelbranch = UserModelBranch::find($usermodelbranchid);
        if (!$usermodelbranch) {
            return redirect()->back()->with('danger', __('app.gym.empty_model'));
        }
        if ($cameraid == 2) {
            $heatmapImage = Image::where('status', 1)->where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'DESC')->first();

        } else {
            $heatmapImage = Image::where('status', 1)->where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'ASC')->first();

        }
        if ($heatmapImage) {
            $regions = Heatmap::select('region')->where('image_id', $heatmapImage->id)->where('user_model_branch_id', $usermodelbranchid)->groupBy('region')->get();
            $heatmy = Heatmap::select('year')->where('image_id', $heatmapImage->id)->where('user_model_branch_id', $usermodelbranchid)->groupBy('year')->get();
            $heatmapImages = Image::where('status', 1)->where('user_model_branch_id', $usermodelbranchid)->limit(2)->get();
            $camcount = 1;
            if (count($heatmapImages) < 2) {
                $camcount = 1;
            } else {
                $camcount = 2;
            }
        } else {
            $heatmapImages = '';
            $heatmapImage = '';
            $regions = '';
            $heatmy = '';
            $camcount = 0;

        }
        return view('customer.preview.branch.heatmap', compact('camcount', 'cameraid', 'heatmapImages', 'heatmapImage', 'heatmy', 'regions', 'branch_id', 'modelswithbranches', 'activebranches', 'usermodelbranchid', 'usermodelbranch'));
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

        $activeRegions = Region::where('active', true)->where('user_id', parentID())->get();

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

        return $this->placesRepo->shiftSettingSave($request, $usermodelbranchid);
    }

    public function placesfilter(Request $request, $branch_id, $usermodelbranchid)
    {

        $validator = Validator::make($request->all(), [
            'end' => 'nullable|date',
            'start' => 'nullable|date',
            'submittype' => 'required',
            'exportType' => 'required_if:submittype,2',
        ],[
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

        $activeRegions = Region::where('active', true)->where('user_id', parentID())->get();

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


        $activeRegions = Region::where('active', true)->where('user_id', parentID())->get();

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

        return view('customer.preview.branch.plates', compact('charts', 'current_branch', 'activeRegions', 'starttime', 'endtime', 'areatimes', 'branch_id', 'modelswithbranches', 'activebranches', 'screen', 'notify', 'usermodelbranchid', 'usermodelbranch', 'lastsetting', 'modelrecords', 'data', 'start', 'end'));
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
            'end' => 'nullable|date',
            'start' => 'nullable|date',
            'submittype' => 'required',
            'exportType' => 'required_if:submittype,2',
        ],[
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
        $activeRegions = Region::where('active', true)->where('user_id', parentID())->get();

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

            if ($file->status && Storage::disk('public')->exists($file->url) ) {

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


        return view('customer.preview.branch.plates', compact('charts', 'current_branch', 'activeRegions', 'starttime', 'endtime', 'areatimes', 'branch_id', 'modelswithbranches', 'activebranches', 'screen', 'notify', 'usermodelbranchid', 'usermodelbranch', 'lastsetting', 'modelrecords', 'data', 'start', 'end'));

    }

    public function mask($branch_id, $usermodelbranchid)
    {
        $activepackage = UserPackages::where('user_id', parentID())->where('active', '1')->first();
        $user = Auth::user();
        $activebranches = [];
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
            $item = Branch::findOrFail($branch_id);
            if ($item->user_id != $user->id) {
                return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
            }
            $activebranches = DB::table('user_model_branches')
                ->select(DB::raw('distinct(branches.id) as b_id, branches.name as bname'))
                ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
                ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
                ->whereNull('user_model_branches.deleted_at')
                ->whereNull('branches.deleted_at')
                ->whereNull('users_models.deleted_at')
                ->where('users_models.user_package_id', $activepackage->id)->distinct()->get();
        }


        $query = DB::table('user_model_branches')
            ->select(['user_model_branches.*', 'branches.id as b_id', 'branches.name as bname', 'models.name as mname', 'lt_models.id as lt_id'])
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->join('models', 'models.id', '=', 'users_models.model_id')
            ->join('lt_models', 'lt_models.id', '=', 'models.lt_model_id')
            ->whereNull('user_model_branches.deleted_at')
            ->whereNull('branches.deleted_at')
            ->whereNull('users_models.deleted_at')
            ->where('users_models.user_package_id', $activepackage->id)
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
            if ($modelfeature == 15) {
                $screen = true;
            }
            if ($modelfeature == 16) {
                $notify = true;
            }
        }

        $lastsetting = $this->maskRepo->getUserShiftSettingByUserModel($usermodelbranchid);
        $modelrecords = $this->maskRepo->getRecordsByUserModelId($usermodelbranchid, null, null, $starttime, $endtime);
        $data = $modelrecords['data'];
        $modelrecords['allsetting'] = MaskSetting::where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'DESC')->get();


        return view('customer.preview.branch.mask', compact('starttime', 'endtime', 'branch_id', 'modelswithbranches', 'activebranches', 'screen', 'notify', 'usermodelbranchid', 'usermodelbranch', 'lastsetting', 'modelrecords', 'data', 'start', 'end'));
    }

    public function maskshiftSettingSave(Request $request, $branch_id, $usermodelbranchid)
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

        return $this->maskRepo->shiftSettingSave($request, $usermodelbranchid);
    }

    public function maskfilter(Request $request, $branch_id, $usermodelbranchid)
    {

        $validator = Validator::make($request->all(), [
            'end' => 'nullable|date',
            'start' => 'nullable|date',
            'submittype' => 'required',
            'exportType' => 'required',
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
            if ($modelfeature == 15) {
                $screen = true;
            }
            if ($modelfeature == 16) {
                $notify = true;
            }
        }
        if (!$usermodelbranch) {
            return redirect()->back()->with('danger', __('app.gym.empty_model'));
        }
        $lastsetting = $this->maskRepo->getUserShiftSettingByUserModel($usermodelbranchid);
        $modelrecords = $this->maskRepo->getRecordsByUserModelId($usermodelbranchid, $start, $end, $starttime, $endtime);
        $data = $modelrecords['data'];
        $modelrecords['allsetting'] = MaskSetting::where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'DESC')->get();


        $list = $modelrecords['list'];
        if ($submittype == 2) {   //for export
            if ($type == 1) {  //type pdf

                view()->share('data', $list);
                $pdf = PDF::loadView('customer.preview.mask.maskpdf', compact(['list']));
                return $pdf->download('maskRecords.pdf');

            } else {
                return Excel::download(new MaskExcelExport($list), 'mask_data.xlsx');

            }
        }
        return view('customer.preview.branch.mask', compact('starttime', 'endtime', 'branch_id', 'modelswithbranches', 'activebranches', 'screen', 'notify', 'usermodelbranchid', 'usermodelbranch', 'lastsetting', 'modelrecords', 'data', 'start', 'end'));

    }

    public function emotion($branch_id, $usermodelbranchid)
    {
        $activepackage = UserPackages::where('user_id', parentID())->where('active', '1')->first();
        $user = Auth::user();
        $activebranches = [];
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
            $item = Branch::findOrFail($branch_id);
            if ($item->user_id != $user->id) {
                return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
            }
            $activebranches = DB::table('user_model_branches')
                ->select(DB::raw('distinct(branches.id) as b_id, branches.name as bname'))
                ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
                ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
                ->whereNull('user_model_branches.deleted_at')
                ->whereNull('branches.deleted_at')
                ->whereNull('users_models.deleted_at')
                ->where('users_models.user_package_id', $activepackage->id)->distinct()->get();
        }


        $query = DB::table('user_model_branches')
            ->select(['user_model_branches.*', 'branches.id as b_id', 'branches.name as bname', 'models.name as mname', 'lt_models.id as lt_id'])
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->join('models', 'models.id', '=', 'users_models.model_id')
            ->join('lt_models', 'lt_models.id', '=', 'models.lt_model_id')
            ->whereNull('user_model_branches.deleted_at')
            ->whereNull('branches.deleted_at')
            ->whereNull('users_models.deleted_at')
            ->where('users_models.user_package_id', $activepackage->id)
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
        $year = 'all';
        $month = 'all';
        $screen = false;
        $notify = false;
        $usermodelbranch = UserModelBranch::find($usermodelbranchid);
        if (!$usermodelbranch) {
            return redirect()->back()->with('danger', __('app.gym.empty_model'));
        }
        $usermodel = $usermodelbranch->usermodel;
        $modelfeatures = json_decode($usermodel->features);
        foreach ($modelfeatures as $modelfeature) {
            if ($modelfeature == 13) {
                $screen = true;
            }
            if ($modelfeature == 14) {
                $notify = true;
            }
        }

        $lastsetting = $this->emotionRepo->getUserShiftSettingByUserModel($usermodelbranchid);
        $modelrecords = $this->emotionRepo->getRecordsByUserModelId($usermodelbranchid, null, null, $starttime, $endtime);
        $statisticdata = $this->emotionRepo->getStatisticsByUserModelId($usermodelbranchid, $start, $end, $year, $month, $starttime, $endtime);
        $data = $modelrecords['data'];
        $modelrecords['allsetting'] = EmotionSetting::where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'DESC')->get();


        return view('customer.preview.branch.emotion', compact('starttime', 'endtime', 'year', 'month', 'statisticdata', 'branch_id', 'modelswithbranches', 'activebranches', 'screen', 'notify', 'usermodelbranchid', 'usermodelbranch', 'lastsetting', 'modelrecords', 'data', 'start', 'end'));
    }

    public function emotionshiftSettingSave(Request $request, $branch_id, $usermodelbranchid)
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

        return $this->emotionRepo->shiftSettingSave($request, $usermodelbranchid);
    }

    public function emotionfilter(Request $request, $branch_id, $usermodelbranchid)
    {

        $validator = Validator::make($request->all(), [
            'end' => 'nullable|date',
            'start' => 'nullable|date',
            'submittype' => 'required',
            'exportType' => 'required',
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
        $start = $request->start;
        $end = $request->end;
        $starttime = $request->starttime;
        $endtime = $request->endtime;
        $year = 'all';
        $month = 'all';
        $submittype = $request->submittype;
        $type = $request->exportType;
        $screen = false;
        $notify = false;
        $usermodelbranch = UserModelBranch::find($usermodelbranchid);
        $usermodel = $usermodelbranch->usermodel;
        $modelfeatures = json_decode($usermodel->features);
        foreach ($modelfeatures as $modelfeature) {
            if ($modelfeature == 13) {
                $screen = true;
            }
            if ($modelfeature == 14) {
                $notify = true;
            }
        }
        if (!$usermodelbranch) {
            return redirect()->back()->with('danger', __('app.gym.empty_model'));
        }
        $lastsetting = $this->emotionRepo->getUserShiftSettingByUserModel($usermodelbranchid);
        $modelrecords = $this->emotionRepo->getRecordsByUserModelId($usermodelbranchid, $start, $end, $starttime, $endtime);
        $statisticdata = $this->emotionRepo->getStatisticsByUserModelId($usermodelbranchid, $start, $end, $year, $month, $starttime, $endtime);

        $data = $modelrecords['data'];
        $modelrecords['allsetting'] = EmotionSetting::where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'DESC')->get();


        $list = $modelrecords['list'];
        if ($submittype == 2) {   //for export
            if ($type == 1) {  //type pdf

                view()->share('data', $list);
                $pdf = PDF::loadView('customer.preview.emotion.emotionpdf', compact(['list']));
                return $pdf->download('emotionRecords.pdf');

            } else {
                return Excel::download(new EmotionExcelExport($list), 'emotion_data.xlsx');

            }
        }
        return view('customer.preview.branch.emotion', compact('starttime', 'endtime', 'year', 'month', 'statisticdata', 'branch_id', 'modelswithbranches', 'activebranches', 'screen', 'notify', 'usermodelbranchid', 'usermodelbranch', 'lastsetting', 'modelrecords', 'data', 'start', 'end'));

    }

    public function car($branch_id, $usermodelbranchid)
    {
        $activepackage = UserPackages::where('user_id', parentID())->where('active', '1')->first();
        $user = Auth::user();
        $activebranches = [];
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
            $item = Branch::findOrFail($branch_id);
            if ($item->user_id != $user->id) {
                return redirect()->route('customerBranches.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
            }
            $activebranches = DB::table('user_model_branches')
                ->select(DB::raw('distinct(branches.id) as b_id, branches.name as bname'))
                ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
                ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
                ->whereNull('user_model_branches.deleted_at')
                ->whereNull('branches.deleted_at')
                ->whereNull('users_models.deleted_at')
                ->where('users_models.user_package_id', $activepackage->id)->distinct()->get();
        }


        $query = DB::table('user_model_branches')
            ->select(['user_model_branches.*', 'branches.id as b_id', 'branches.name as bname', 'models.name as mname', 'lt_models.id as lt_id'])
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->join('models', 'models.id', '=', 'users_models.model_id')
            ->join('lt_models', 'lt_models.id', '=', 'models.lt_model_id')
            ->whereNull('user_model_branches.deleted_at')
            ->whereNull('branches.deleted_at')
            ->whereNull('users_models.deleted_at')
            ->where('users_models.user_package_id', $activepackage->id)
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
        $year = 'all';
        $month = 'all';
        $screen = false;
        $notify = false;
        $usermodelbranch = UserModelBranch::find($usermodelbranchid);
        if (!$usermodelbranch) {
            return redirect()->back()->with('danger', __('app.gym.empty_model'));
        }
        $usermodel = $usermodelbranch->usermodel;
        $modelfeatures = json_decode($usermodel->features);
        foreach ($modelfeatures as $modelfeature) {
            if ($modelfeature == 7) {
                $screen = true;
            }
            if ($modelfeature == 8) {
                $notify = true;
            }
        }


        $lastsetting = $this->carRepo->getUserShiftSettingByUserModel($usermodelbranchid);
        $modelrecords = $this->carRepo->getRecordsByUserModelId($usermodelbranchid, null, null, $starttime, $endtime);
        $statisticdata = $this->carRepo->getStatisticsByUserModelId($usermodelbranchid, $start, $end, $year, $month, $starttime, $endtime);
        $data = $modelrecords['data'];

        $sum = (array)DB::table('car_counts')->get([
            DB::raw('SUM(car_count) as car'),
            DB::raw('SUM(truck_count) as truck'),
            DB::raw('SUM(pickup_truck_count) as pickup_truck'),
            DB::raw('SUM(work_van_count) as work_van'),
            DB::raw('SUM(bus_count) as bus_count'),
            DB::raw('SUM(motorcycle_count) as motorcycle'),
        ])->first();

        $display = [
            "max" => max($sum),
            "max_name" => array_keys($sum, max($sum)),
            "low" => min($sum),
            "low_name" => array_keys($sum, min($sum)),
            "total" => array_sum($sum)
        ];

        $modelrecords['allsetting'] = CarSetting::where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'DESC')->get();


        return view('customer.preview.branch.car', compact('starttime', 'endtime', 'year', 'display', 'month', 'statisticdata', 'branch_id', 'modelswithbranches', 'activebranches', 'screen', 'notify', 'usermodelbranchid', 'usermodelbranch', 'lastsetting', 'modelrecords', 'data', 'start', 'end'));
    }

    public function carshiftSettingSave(Request $request, $branch_id, $usermodelbranchid)
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

        return $this->carRepo->shiftSettingSave($request, $usermodelbranchid);
    }

    public function carfilter(Request $request, $branch_id, $usermodelbranchid)
    {

        $validator = Validator::make($request->all(), [
            'end' => 'nullable|date',
            'start' => 'nullable|date',
            'submittype' => 'required',
            'exportType' => 'required',
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
        $start = $request->start;
        $end = $request->end;
        $starttime = $request->starttime;
        $endtime = $request->endtime;
        $year = 'all';
        $month = 'all';
        $submittype = $request->submittype;
        $type = $request->exportType;
        $screen = false;
        $notify = false;
        $usermodelbranch = UserModelBranch::find($usermodelbranchid);
        $usermodel = $usermodelbranch->usermodel;
        $modelfeatures = json_decode($usermodel->features);
        foreach ($modelfeatures as $modelfeature) {
            if ($modelfeature == 13) {
                $screen = true;
            }
            if ($modelfeature == 14) {
                $notify = true;
            }
        }
        if (!$usermodelbranch) {
            return redirect()->back()->with('danger', __('app.gym.empty_model'));
        }
        $lastsetting = $this->carRepo->getUserShiftSettingByUserModel($usermodelbranchid);
        $modelrecords = $this->carRepo->getRecordsByUserModelId($usermodelbranchid, $start, $end, $starttime, $endtime);
        $statisticdata = $this->carRepo->getStatisticsByUserModelId($usermodelbranchid, $start, $end, $year, $month, $starttime, $endtime);

        $data = $modelrecords['data'];

        $sum = (array)DB::table('car_counts')->get([
            DB::raw('SUM(car_count) as car'),
            DB::raw('SUM(truck_count) as truck'),
            DB::raw('SUM(pickup_truck_count) as pickup_truck'),
            DB::raw('SUM(work_van_count) as work_van'),
            DB::raw('SUM(bus_count) as bus_count'),
            DB::raw('SUM(motorcycle_count) as motorcycle'),
        ])->first();

        $display = [
            "max" => max($sum),
            "max_name" => array_keys($sum, max($sum)),
            "low" => min($sum),
            "low_name" => array_keys($sum, min($sum)),
            "total" => array_sum($sum)
        ];

        $modelrecords['allsetting'] = CarSetting::where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'DESC')->get();

        $list = $modelrecords['list'];
        if ($submittype == 2) {   //for export
            if ($type == 1) {  //type pdf

                view()->share('data', $list);
                $pdf = PDF::loadView('customer.preview.car.carpdf', compact(['list']));
                return $pdf->download('carsRecords.pdf');

            } else {
                return Excel::download(new CarsExcelExport($list), 'cars_data.xlsx');

            }
        }
        return view('customer.preview.branch.car', compact('starttime', 'endtime', 'year', 'display', 'month', 'statisticdata', 'branch_id', 'modelswithbranches', 'activebranches', 'screen', 'notify', 'usermodelbranchid', 'usermodelbranch', 'lastsetting', 'modelrecords', 'data', 'start', 'end'));

    }

}
