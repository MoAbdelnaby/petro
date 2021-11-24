<?php

namespace App\Http\Controllers\Api;

use App\BranchNetWork;
use App\BranchStatus;
use App\Http\Repositories\Eloquent\ApiRepo;
use App\Http\Requests\ApiModelRequest;
use App\Http\Requests\CarCountRequest;
use App\Http\Requests\CarPlatesRequest;
use App\Http\Requests\DoorRequest;
use App\Http\Requests\EmotionRequest;
use App\Http\Requests\HeatmapRequest;
use App\Http\Requests\MaskRequest;
use App\Http\Requests\PeopleRequest;
use App\Http\Requests\PlacesRequest;
use App\Http\Requests\RecieptionRequest;
use App\Http\Requests\VechileRequest;
use App\Http\Resources\BaysResource;
use App\Http\Resources\VehiclesResource;
use App\Models\AreaStatus;
use App\Models\Branch;
use App\Models\Carprofile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Response;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiModelController extends Controller
{
    protected $repo;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(ApiRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSetting(ApiModelRequest $request)
    {
        return $this->repo->getUserSettingByBranchModelName($request->all());
    }

    public function saveDoorRecord(DoorRequest $request)
    {
        $screenshot = null;
        if ($request->hasFile('screenshot')) {
            $screenshot = $this->repo->savescreenshot($request->screenshot);
        }
        $data = [
            'user_model_branch_id' => $request->user_model_branch_id,
            'setting_id' => $request->setting_id,
            'count' => $request->count ? $request->count : 0,
            'date' => $request->date,
            'time' => $request->time,
            'camera_id' => $request->camera_id ? $request->camera_id : 1,
            'screenshot' => $screenshot,
            'active' => $request->active ? $request->active : 1,
        ];
        return $this->repo->saveDoorRecord($data);
    }

    public function saveRecieptionRecord(RecieptionRequest $request)
    {
        $screenshot = null;
        if ($request->hasFile('screenshot')) {
            $screenshot = $this->repo->savescreenshot($request->screenshot);
        }
        $data = [
            'user_model_branch_id' => $request->user_model_branch_id,
            'setting_id' => $request->setting_id,
            'count' => $request->count,
            'date' => $request->date,
            'time' => $request->time,
            'camera_id' => $request->camera_id ? $request->camera_id : 1,
            'screenshot' => $screenshot,
            'active' => $request->active ? $request->active : 1,
        ];
        return $this->repo->saveRecieptionRecord($data);
    }

    public function saveCarPlatesRecord(CarPlatesRequest $request)
    {
//        \Log::info('car plate function', $request->all() );
        try {

            $screenshot = null;
            if ($request->hasFile('screenshot')) {
                $screenshot = $this->repo->saveScreenShot($request->screenshot);
            }

            $data = [
                'user_model_branch_id' => $request->user_model_branch_id,
                'setting_id' => $request->setting_id,
                'area' => $request->area,
                'plate_no' => $request->plate_no,
                'date' => $request->date,
                'time' => $request->time,
                'camera_id' => $request->camera_id ? $request->camera_id : 1,
                'screenshot' => $screenshot,
                'active' => $request->active ? $request->active : 1,
            ];
            return $this->repo->saveCarPlatesRecord($data);

        } catch (\Exeption $e) {
            return $this->errorMsg('There is some error : ' . $e->getMessage(), 500);
        }
    }

    public function savePeopleRecord(PeopleRequest $request)
    {
        $screenshot = null;
        if ($request->hasFile('screenshot')) {
            $screenshot = $this->repo->savescreenshot($request->screenshot);
        }
        $data = [
            'user_model_branch_id' => $request->user_model_branch_id,
            'setting_id' => $request->setting_id,
            'count' => $request->count,
            'date' => $request->date,
            'time' => $request->time,
            'camera_id' => $request->camera_id ? $request->camera_id : 1,
            'screenshot' => $screenshot,
            'active' => $request->active ? $request->active : 1,
        ];
        return $this->repo->savePeopleRecord($data);
    }

    public function saveCarCountRecord(CarCountRequest $request)
    {
        $screenshot = null;
        if ($request->hasFile('screenshot')) {
            $screenshot = $this->repo->savescreenshot($request->screenshot);
        }
        $data = [
            'user_model_branch_id' => $request->user_model_branch_id,
            'setting_id' => $request->setting_id,
            'car_count' => $request->car,
            'truck_count' => $request->truck,
            'pickup_truck_count' => $request->pickup_truck,
            'work_van_count' => $request->work_van,
            'bus_count' => $request->bus,
            'motorcycle_count' => $request->motorcycle,
            'date' => $request->date,
            'time' => $request->time,
            'camera_id' => $request->camera_id ? $request->camera_id : 1,
            'screenshot' => $screenshot,
            'active' => $request->active ? $request->active : 1,
        ];
        return $this->repo->saveCarCountRecord($data);
    }

    public function saveEmotionRecord(EmotionRequest $request)
    {
        $screenshot = null;
        if ($request->hasFile('screenshot')) {
            $screenshot = $this->repo->savescreenshot($request->screenshot);
        }
        $data = [
            'user_model_branch_id' => $request->user_model_branch_id,
            'setting_id' => $request->setting_id,
            'happy' => $request->happy,
            'angry' => $request->angry,
            'neutral' => $request->neutral,
            'surprise' => $request->surprise,
            'disgust' => $request->disgust,
            'sad' => $request->sad,
            'fear' => $request->fear,
            'date' => $request->date,
            'time' => $request->time,
            'camera_id' => $request->camera_id ? $request->camera_id : 1,
            'screenshot' => $screenshot,
            'active' => $request->active ? $request->active : 1,
        ];
        return $this->repo->saveEmotionRecord($data);
    }

    public function saveMaskRecord(MaskRequest $request)
    {
        $screenshot = null;
        if ($request->hasFile('screenshot')) {
            $screenshot = $this->repo->savescreenshot($request->screenshot);
        }
        $data = [
            'user_model_branch_id' => $request->user_model_branch_id,
            'setting_id' => $request->setting_id,
            'mask' => $request->mask,
            'nomask' => $request->nomask,
            'date' => $request->date,
            'time' => $request->time,
            'camera_id' => $request->camera_id ? $request->camera_id : 1,
            'screenshot' => $screenshot,
            'active' => $request->active ? $request->active : 1,
        ];
        return $this->repo->saveMaskRecord($data);
    }

    public function saveHeatMapRecord(HeatmapRequest $request)
    {
        $data = [];
        foreach ($request->regions as $key => $value) {

            $data[] = [
                'user_model_branch_id' => $request->user_model_branch_id,
                'year' => $request->year,
                'month' => $request->month,
                'day' => $request->day,
                'hour' => $request->hour,
                'region' => array_keys($value)[0],
                'value' => array_values($value)[0],
                'image_id' => $request->image_id,
                'camera_id' => $request->camera_id ? $request->camera_id : 1,
                'active' => $request->active ? $request->active : 1,
            ];

        }
        return $this->repo->saveHeatMapRecord($data);
    }

    public function savePlaceRecord(PlacesRequest $request)
    {
        $screenshot = null;
        if ($request->hasFile('screenshot')) {
            $screenshot = $this->repo->savescreenshot($request->screenshot);
        }
        $data = [
            'user_model_branch_id' => $request->user_model_branch_id,
            'setting_id' => $request->setting_id,
            'area' => $request->area,
            'status' => $request->status,
            'date' => $request->date,
            'time' => $request->time,
            'camera_id' => $request->camera_id ? $request->camera_id : 1,
            'screenshot' => $screenshot,
            'active' => $request->active ? $request->active : 1,
        ];


        return $this->repo->savePlaceRecord($data);
    }

    public function getBusyBays($id)
    {
        $data = cache()->remember('branch_status', 10, function () {
            return DB::table('busy_area_branch_view')->get();
        });

        $data = $data->where('branch_code', $id);

        return response()->json([
            'success' => true,
            'message' => empty($data) ? 'No Busy Bays At This Moment' : 'Data Returned Successfully',
            'bays' => BaysResource::collection($data)
        ], 200);
    }

    public function getVehicles(VechileRequest $request)
    {
        $branch = Branch::where('code', $request->StationCode)->first();

        if ($branch) {
            DB::unprepared("SET @@sql_mode :=''");
            $results = Carprofile::selectRaw('carprofiles.*')
                ->where('status', 'completed')
                ->where('plate_status', '!=', 'error')
                ->orWhere('plate_status', '!=', 'reported')
                ->where('branch_id', $branch->id)
                ->where('checkInDate', '>=', $request->FromDate)
                ->where('checkInDate', '<=', $request->ToDate)
                ->groupBy('plateNumber')->orderBy('checkInDate', 'desc')
                ->orderBy('checkInDate', 'desc')
                ->get();
            DB::unprepared("SET @@sql_mode :='ONLY_FULL_GROUP_BY'");


//            DB::unprepared("SET @@sql_mode :=''");
//            $query = Carprofile::selectRaw('carprofiles.*')
//                ->where('status', 'completed')
//                ->where('branch_id',$branch->id);
//            if($request->FromDate){
//                $query=$query->whereDate('checkInDate','>=',$request->FromDate);
//            }
//            if($request->ToDate){
//                $query=$query->whereDate('checkInDate','<=',$request->ToDate);
//            }
//            $query = $query->groupBy('plateNumber')->orderBy('checkInDate','desc');
//
////            $list=$query;
//            $results = $query->get();
////            $paginated = $list->paginate(10);
//            DB::unprepared("SET @@sql_mode :='ONLY_FULL_GROUP_BY'");


            if (!$results) {
                return response()->json(['success' => true, 'message' => 'No Vehicles in That period', 'Vehicles' => []], 200);
            }
            return response()->json(['success' => true, 'message' => 'Data Returned Successfully', 'Vehicles' => VehiclesResource::collection($results)], 200);
        }

        return response()->json(['success' => false, 'message' => 'Station Code Not Found'], 200);
    }

    public function branchNetwork(Request $request) {
        try {
            $json = array();
            /* get branch */
            $branch = Branch::where("code",$request->branch_code)->first();
            /* end of get branch */
            if ($branch) {
                if ($branch->active == 1) {
                    $create = BranchNetWork::create([
                        'user_id' => Auth::id(),
                        'branch_code' => $request->branch_code,
                        'error' => json_encode($request->last_error),
                        'status' => $request->status,
                    ]);
                    /* last of error */
                    $branchStatus = BranchStatus::where('branch_code',$request->branch_code)->get();
                    /* End */
                    if ($create) {
                        /* response successfully */
                        $json['status'] = 'success';
                        $json['message'] = 'store branch status successfully';
                        $json['code'] = 200;
                    }else {
                        $json['status'] = 'field';
                        $json['message'] = 500;
                        $json['code'] = 'issue of creation branch status';
                    }
                    return response()->json(['data' => $json],$json['code']);
                } else {
                    return response()->json(['data' => [], 'message' => 'this Branch is inActive', 'code' => 200],200);
                }
            } else {
                return response()->json(['data' => [], 'message' => 'Branch Not Found', 'code' => 404],404);
            }
        }catch (\Exception $e) {
            return response()->json(['data'=> [], 'message' => $e->getMessage(),$e->getCode()],$e->getCode());
        }
    }

}
