<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Carprofile;
use App\Services\PlateServices;
use App\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ErrorManagementController extends Controller
{

    public function index($model, Request $request)
    {
        try {
            $request->validate([
                'branch_id' => 'sometimes|nullable|exists:branches,id',
            ]);

            $branches = DB::table('branches')
                ->select('branches.*')
                ->join('view_top_branch_plate', 'branches.id', '=', 'view_top_branch_plate.branch_id')
                ->where('active', true)
                ->where('user_id', parentID())
                ->orderBy('view_top_branch_plate.count', 'DESC')
                ->get();

            $userSettings = UserSetting::where('user_id', auth()->id())->first();

            $data = [];
            $type = 'plate';
            switch ($model) {
                case 9:
                    $data = Carprofile::select('carprofiles.*', 'branches.name as branch','branches.id as branch_ids')
                        ->where('status', 'completed')
                        ->where(function ($q){
                            return $q->where('plate_status', 'error')
                                ->orWhere('plate_status', 'reported')
                                ->orWhere('plate_status', 'modified');
                        })
                        ->whereNotNull('screenshot')
                        ->join('branches', 'carprofiles.branch_id', '=', 'branches.id')
                        ->when(request('branch_id'), function ($q) {
                            return $q->where('carprofiles.branch_id', request('branch_id'));
                        });

                    $type = 'plate';
                    break;
            }

            $data = ($data != []) ? $data->latest()->paginate(10) : [];

            return view("customer.errorsManagement.$type", compact('branches', 'data', 'userSettings'));

        } catch (\Exception $e) {
            return redirect('/');
        }
    }

    public function updatePlate(Request $request)
    {
        try {

            $plate_ar = trim($request->plate_ar) . ' ' . trim($request->number_ar);
            $plate_en = trim($request->plate_en) . ' ' . trim($request->number_en);

            $plate = "upper: ".str_replace(' ','.',$plate_ar) ." lower: ".str_replace(' ','.',$plate_en);

            $plateService = new PlateServices();
            $plate = $plateService->resolvePlate($plate);

            if ($plate['number_status'] == false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Plate Number Not correct',
                ],400);
            }
            if ($plate['char_status'] == false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Plate Char Not correct',
                ],400);
            }
            if ($plate['status'] == 'error') {
                return response()->json([
                    'success' => false,
                    'message' => 'Plate updated failed',
                ],400);
            }

            $carprofile = Carprofile::find($request->item_id);
            $carprofile->plate_ar =  $plate['plate_ar']['plate'];
            $carprofile->plate_en = $plate['plate_en']['plate'];
            $carprofile->plateNumber = $plate['plate'];
            $carprofile->plate_status = 'modified';
            $carprofile->save();

            return response()->json([
                'success' => true,
                'message' => 'Plate updated successfully',
                'data' => $carprofile
            ]);

        } catch (\Exception $e) {
            response()->json([
                'success' => false,
                'message' => 'Plate updated failed',
            ],400);
        }
    }

}
