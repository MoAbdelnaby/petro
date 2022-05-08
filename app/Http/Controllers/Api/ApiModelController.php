<?php

namespace App\Http\Controllers\Api;

use App\BranchNetWork;
use App\BranchStatus;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\ApiRepo;
use App\Http\Requests\ApiModelRequest;
use App\Http\Requests\CarPlatesRequest;
use App\Http\Requests\PlacesRequest;
use App\Http\Resources\BaysResource;
use App\Models\Branch;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiModelController extends Controller
{
    protected $repo;

    /**
     * @param ApiRepo $repo
     */
    public function __construct(ApiRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param ApiModelRequest $request
     * @return JsonResponse
     */
    public function getSetting(ApiModelRequest $request)
    {
        return $this->repo->getUserSettingByBranchModelName($request->all());
    }

    public function saveCarPlatesRecord(CarPlatesRequest $request)
    {
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
                'camera_id' => $request->camera_id ?: 1,
                'screenshot' => $screenshot,
                'active' => $request->active ?: 1,
            ];
            return $this->repo->saveCarPlatesRecord($data);

        } catch (Exception $e) {
            return $this->errorMsg('There is some error : ' . $e->getMessage(), 500);
        }
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function branchNetwork(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'branch_code' => 'required',
            'last_error' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            $json['status'] = 'field';
            $json['code'] = 500;
            $json['message'] = 'issue of creation branch status';

            return response()->json(['data' => $json], $json['code']);
        }

        try {
            $json = [];
            $branchStatusArr = [];
            $branch = Branch::where("code", $request->branch_code)->first();

            if ($branch) {

                DB::table('branches_users')
                    ->where('branch_id', $branch->id)
                    ->update(['notified' => '0']);

                if ($branch->active == 1) {
                    $create = BranchNetWork::create([
                        'user_id' => Auth::id(),
                        'branch_code' => $request->branch_code,
                        'error' => json_encode($request->last_error, JSON_THROW_ON_ERROR),
                        'status' => $request->status,
                    ]);

                    //Handle Last Error
                    $branchStatus = BranchStatus::where('branch_code', $request->branch_code)->first();
                    $branchStatusArr['status'] = 'online';
                    $branchStatusArr['created_at'] = Carbon::now();
                    $branchStatusArr['last_error'] = json_encode($request->last_error, JSON_THROW_ON_ERROR);
                    $branchStatusArr['last_connected'] = null;
                    $branchStatusArr['branch_code'] = $request->branch_code;
                    $branchStatusArr['branch_name'] = $branch->name;

                    if ($branchStatus) {
                        $branchStatus->update($branchStatusArr);
                    } else {
                        BranchStatus::create($branchStatusArr);
                    }

                    if ($create) {
                        $json['status'] = 'success';
                        $json['message'] = 'store branch status successfully';
                        $json['code'] = 200;
                    } else {
                        $json['status'] = 'field';
                        $json['code'] = 500;
                        $json['message'] = 'issue of creation branch status';
                    }

                    return response()->json(['data' => $json], $json['code']);
                } else {
                    return response()->json(['data' => [], 'message' => 'this Branch is inActive', 'code' => 200], 200);
                }
            } else {
                return response()->json(['data' => [], 'message' => 'Branch Not Found', 'code' => 404], 404);
            }

        } catch (\Exception $e) {
            return response()->json(['data' => [], 'message' => $e->getMessage(), 'code' => 500], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function testServerLoad(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 500);
        }

        $data = array_merge($validator->validated(), ['created_at' => Carbon::now()]);

        try {
            DB::table('loaders')->insert([
                $data
            ]);
            return response()->json(['success' => true, 'message' => 'Data Returned Successfully'], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
