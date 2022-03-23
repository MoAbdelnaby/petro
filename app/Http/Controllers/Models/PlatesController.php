<?php

namespace App\Http\Controllers\Models;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\PlatesRepo;
use App\Models\Branch;
use App\Models\BranchFiles;
use App\Models\CarPLatesSetting;
use App\Models\Carprofile;
use App\Models\FailedMessage;
use App\Models\Invoice;
use App\Models\UserModelBranch;
use App\Models\UserPackages;
use App\Services\CustomerPhone;
use App\Services\ReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PlatesController extends Controller
{
    protected $repo;

    public function __construct(PlatesRepo $repo)
    {
        $this->repo = $repo;
    }

    public function index($usermodelbranchid)
    {
        $user = Auth::user();
        $usermodelbranch = UserModelBranch::where('id', $usermodelbranchid)->with(['branch' => function ($q) {
            return $q->where('active', true);
        }])->first();

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

        } elseif ($user->type == "customer" || $user->type == "subadmin") {
            $branch = Branch::findOrFail($usermodelbranch->branch_id);
            if ($branch->user_id != $user->id && $user->type != "subadmin") {
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
                    'name' => $result->branch ? $result->branch->name : '',
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
            if ($modelfeature == 11) {
                $screen = true;
            }
            if ($modelfeature == 12) {
                $notify = true;
            }
        }

        $lastsetting = $this->repo->getUserShiftSettingByUserModel($usermodelbranchid);
        $records = $this->repo->getNewData($usermodelbranch->branch_id, $start, $end);
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

        $invoice_chart = ReportService::invoiceComparisonReport('custom', [$usermodelbranch->branch_id]);
        $duration_ratio = ReportService::stayingAverageComparisonReport('custom', [$usermodelbranch->id]);
        $duration_ratio = $duration_ratio[0]['duration']??0;

        return view('customer.preview.plates.plates', compact('invoice_chart', 'duration_ratio', 'charts', 'starttime', 'branch', 'endtime', 'areatimes', 'screen', 'notify', 'lastsetting', 'usermodelbranchid', 'usermodelbranch', 'modelrecords', 'data', 'start', 'end', 'final_branches'));
    }

    public function platesfilter(Request $request, $usermodelbranchid)
    {
        $validator = Validator::make($request->all(), [
            'end' => 'required|date',
            'start' => 'required|date',
            'submittype' => 'required',
            'exportType' => 'required_if:submittype,2',
        ], [
            'exportType.required_if' => 'please select file format first',
        ]);

        if ($validator->errors()->count()) {
            return redirect()->back()->with('danger', $validator->errors()->first());
        }

        $user = Auth::user();
        $usermodelbranch = UserModelBranch::find($usermodelbranchid);

        if (!$usermodelbranch) {
            if ($user->type == "subcustomer") {
                return redirect()->route('myBranches')->with('danger', __('app.gym.empty_branch'));
            } else {
                return redirect()->route('customerPackages.index')->with('danger', __('app.customers.branchmodels.modelnotfound'));
            }
        }

        $data = [];
        if ($user->type == "subcustomer") {
            $data = $user->branches;
            $branches = $data->pluck('id')->toArray();
            if (!in_array($usermodelbranch->branch_id, $branches)) {
                return redirect()->route('myBranches')->with('danger', __('app.gym.empty_branch'));
            }

        } elseif ($user->type == "customer" || $user->type == "subadmin") {
            $item = Branch::findOrFail($usermodelbranch->branch_id);
            if ($item->user_id != $user->id && $user->type != "subadmin") {
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
            ->where('users_models.user_package_id', $activepackage->id)->distinct()->get();

        $brnarray = $activebranches->pluck('id')->toArray();
        $final_branches = [];

        foreach ($brnarray as $value) {
            $result = UserModelBranch::where('branch_id', $value)->where('user_model_id', $usermodelbranch->user_model_id)->first();
            if ($result) {
                $branch = Branch::find($value);
                $final_branches[] = (object)['name' => $branch->name, 'user_model_branch_id' => $result->id];
            }
        }

        $final_start = null;
        $final_end = null;
        $start = null;
        $end = null;
        $starttime = null;
        $endtime = null;

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

        $lastsetting = $this->repo->getUserShiftSettingByUserModel($usermodelbranchid);
        $records = $this->repo->getNewData($usermodelbranch->branch_id, $final_start, $final_end);
        $areatimes = $records['areas_count'] ?? [];
        $list = $records['list'] ?? [];

        $modelrecords['allsetting'] = CarPLatesSetting::where('user_model_branch_id', $usermodelbranchid)->orderBy('id', 'DESC')->get();
        $data = $records['data'] ?? [];

        if ($submittype == 2) {//for export

            $type = ($type == '1') ? 'pdf' : 'xls';

            $start_name = $start ?? 'first';
            $last_name = $end ?? 'last';
            $name = "{$usermodelbranch->branch->name}_file_from_{$start_name}_to_{$last_name}.$type";

            $file = BranchFiles::firstOrCreate([
                'start' => $start ?? null,
                'end' => $end ?? null,
                'user_model_branch_id' => $usermodelbranchid,
                'branch_id' => $usermodelbranch->branch_id,
                'type' => $type,
                'model_type' => 'plate',
            ], [
                'name' => $name,
                'status' => false,
                'user_id' => parentID(),
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

        $charts = [];
        $i = 0;
        foreach ($areatimes as $key => $value) {
            $charts[$i]['area'] = "Area #$key";
            $charts[$i]['count'] = $value;
            $i++;
        }

        $invoice_chart = ReportService::invoiceComparisonReport('custom', [$usermodelbranch->branch_id], $start, $end);
        $duration_ratio = ReportService::stayingAverageComparisonReport('custom', [$usermodelbranch->id], $start, $end);
        $duration_ratio = $duration_ratio[0]['duration']??0;

        return view('customer.preview.plates.plates', compact('invoice_chart', 'duration_ratio', 'charts', 'starttime', 'endtime', 'areatimes', 'screen', 'notify', 'lastsetting', 'usermodelbranchid', 'usermodelbranch', 'modelrecords', 'data', 'start', 'end', 'final_branches'));
    }

    public function platesshiftSettingSave(Request $request, $usermodelbranchid)
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

    public function putError(Request $request)
    {

        if ($request->ajax()) {
            $carprofile = Carprofile::find($request->item_id);
            $carprofile->plate_status = $request->status;
            $carprofile->save();

            return response()->json([
                'success' => true,
                'plate_status' => $carprofile->plate_status
            ], 200);
        }

        return response()->json(['success' => false], 400);

    }


    public function sendMessage(Request $request)
    {

        try {
            $contacts = [];
            $messageTemplate = [];
            if ($request->type == 'Welcome') {
                $contacts = (new CustomerPhone($request->plateNumber))->handle();
                $messageTemplate = ['template_id' => '0'];


            } else {
                $customer = Invoice::where('PlateNumber', str_replace(' ', '', $request->plateNumber))->latest()->first();
                if ($customer) {
                    $messageTemplate = [
                        'template_id' => '2',
                        'distance' => $customer->distance
                    ];
                    $contacts[] = $customer->CustomerPhoneNumber;
                }
            }
            if (count($contacts) >= 1) {
                foreach ($contacts as $phone) {
                    if (!is_null($phone)) {
                        $data = Http::post('https://whatsapp-wakeb.azurewebsites.net/api/petro_template',
                            ['phone' => $phone] + $messageTemplate);

                        if ($data['success'] === true) {
                            $row = FailedMessage::where('carprofile_id', $request->plateID)->delete();
                        } else {
                            FailedMessage::updateOrCreate([
                                'carprofile_id' => $request->plateID,
                            ], [
                                'branch_id' => Carprofile::find($request->plateID)->branch_id,
                                'plateNumber' => $request->plateNumber,
                                'status' => 'twillo'
                            ]);
                        }
                    }
                }

            } else {
                return response()->json(['success' => false, 'message' => 'No Phone Number Found for this plate '], 400);
            }

            $row = Carprofile::where('plate_en', $request->plateNumber)->latest()->first();

            $status = ($request->type == 'Welcome') ? Carbon::now() : Null;

            $row->update([
                'welcome' => $status
            ]);

            return response()->json(['success' => true, 'message' => "Your {$request->type} Message Sent Successfully"], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something went Wrong', 'info' => $e->getMessage()], 500);
        }
    }

    public function get_branch_plate_times(Request $request)
    {
        $start = false;
        $end = false;
        if ($request->date != 'all') {
            $date = getStartEndDate($request->date);
            $start = $date['start'];
            $end = $date['end'];
        }

        $query = DB::table('carprofiles')
            ->select(DB::raw('count(id) as count ,BayCode'))
            ->where('status', 'completed')
            ->where('plate_status', '!=', 'error')
            ->where('branch_id', $request->branch_id)
            ->where('BayCode', $request->area);

        if ($start) {
            $query->whereDate('checkInDate', '>=', $start);
        }

        if ($end) {
            $query->whereDate('checkInDate', '<=', $end);
        }

        $data = $query->first();

        return response()->json(['data' => $data]);
    }

}
