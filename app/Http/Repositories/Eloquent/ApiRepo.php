<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\ApiRepoInterface;
use App\Jobs\SendWelcomeMessage;
use App\Models\AreaStatus;
use App\Models\CarCount;
use App\Models\CarPLates;
use App\Models\CarPLatesSetting;
use App\Models\Carprofile;
use App\Models\CarSetting;
use App\Models\Door;
use App\Models\DoorRecieptionSetting;
use App\Models\Emotion;
use App\Models\EmotionSetting;
use App\Models\Heatmap;
use App\Models\Mask;
use App\Models\MaskSetting;
use App\Models\Models;
use App\Models\PeopleCount;
use App\Models\PeopleSetting;
use App\Models\PlaceMaintenance;
use App\Models\PlaceMaintenanceSetting;
use App\Models\Recieption;
use App\Models\RecieptionSetting;
use App\Models\UserModel;
use App\Models\Branch;
use App\Models\UserModelBranch;
use App\Models\UserPackages;
use App\Phonetics\Phonetics;
use App\Services\PlateServices;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use mysql_xdevapi\Exception;

class ApiRepo implements ApiRepoInterface
{


    public function __construct()
    {
    }

    private function successMsg($message)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    private function errorMsg($message, $code)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }

    public function getUserSettingByBranchModelName($data)
    {

        $user = auth('api')->user();
        $package = UserPackages::where('user_id', $user->id)->where('active', 1)->first();
        if ($package) {

            $branch = Branch::where('code', $data['code'])->where('user_id', auth()->user()->id)->where('active', 1)->first();
            if ($branch) {
                $model = Models::where('name', $data['model_name'])->where('active', 1)->first();
                if ($model) {
                    $userModel = UserModel::where('model_id', $model->id)->where('user_package_id', $package->id)->first();
                    if ($userModel) {
                        $userModelbranch = UserModelBranch::where('user_model_id', $userModel->id)->where('branch_id', $branch->id)->first();
                        if ($userModelbranch) {
                            $setting = null;
                            switch ($model->lt_model_id) {
                                case 1:
                                    $setting = DoorRecieptionSetting::where('user_model_branch_id', $userModelbranch->id)->where('active', 1)->first();
                                    break;
                                case 2:
                                    $setting = RecieptionSetting::where('user_model_branch_id', $userModelbranch->id)->where('active', 1)->first();
                                    break;
                                case 3:
                                    $setting = PeopleSetting::where('user_model_branch_id', $userModelbranch->id)->where('active', 1)->first();
                                    break;
                                case 4:
                                    $setting = CarSetting::where('user_model_branch_id', $userModelbranch->id)->where('active', 1)->first();
                                    break;
                                case 5:
                                    $setting = EmotionSetting::where('user_model_branch_id', $userModelbranch->id)->where('active', 1)->first();
                                    break;
                                case 6:
                                    $setting = MaskSetting::where('user_model_branch_id', $userModelbranch->id)->where('active', 1)->first();
                                    break;
                                case 7:
                                    $setting = null;
                                    break;
                                case 8:
                                    $setting = PlaceMaintenanceSetting::where('user_model_branch_id', $userModelbranch->id)->where('active', 1)->first();
                                    break;
                                case 9:
                                    $setting = CarPLatesSetting::where('user_model_branch_id', $userModelbranch->id)->where('active', 1)->first();
                                    break;

                                default:
                                    $setting = null;
                            }
                            return response()->json([
                                'success' => true,
                                'userModelbranchId' => $userModelbranch->id,
                                'area_count' => $branch->area_count,
                                'setting' => $setting,
                                'message' => 'Data Retrieved Successfully',
                            ]);
                        } else {

                            return $this->errorMsg('User Model Not Assigned to this branch', 400);

                        }
                    } else {

                        return $this->errorMsg('Invalid User Model name', 400);

                    }
                } else {

                    return $this->errorMsg('Invalid Model name', 400);

                }
            } else {

                return $this->errorMsg('Invalid Branch Code', 400);
            }
        } else {
            return $this->errorMsg('There is no Package assigned to this user', 400);
        }
    }

    public function saveScreenShot($screenshot)
    {
        $imageName = time() . '-' . $screenshot->getClientOriginalName();
        $imageName = trim(str_replace(' ', '-', $imageName));

        if (!is_dir(storage_path("/app/public/screenshot"))) {
            \File::makeDirectory(storage_path("/app/public/screenshot"), 777);
        }
        $screenshot->move(storage_path('app/public/screenshot'), $imageName);
        return '/screenshot/' . $imageName;
    }

    public function saveDoorRecord($data)
    {
        try {
            $insert = Door::create($data);
            if ($insert) {
                return response()->json([
                    'success' => true,
                    'message' => ' Data Inserted Successfully',
                ]);
            } else {
                return $this->errorMsg('There is Error While Saving record', 400);
            }

        } catch (\Exception $e) {

            return $this->errorMsg('There is Error While Saving record', 400);
        }
    }


//    public function saveCarPlatesRecord($data)
//    {
//        try {
//
//            $plateNumber = $data['plate_no'];
//            $en_plate = Str::after($plateNumber, 'lower: ');
//            $ar_plate = Str::after(Str::before($plateNumber,' lower: '), 'upper: ');
//
//            if (mb_strlen($ar_plate) != 13 && mb_strlen($en_plate) == 13) {
//                $obj = new Phonetics();
//                $ar_result =  $obj->convertLetters($en_plate, 'en');
//                $lastplate = 'upper: ' .$ar_result.' lower: '.$en_plate;
//
//            }elseif(mb_strlen($ar_plate) == 13 && mb_strlen($en_plate) != 13) {
//                $obj = new Phonetics();
//                $en_result =  $obj->convertLetters($ar_plate);
//                $lastplate = 'upper: ' .$ar_plate.' lower: '.$en_result;
//
//            }elseif(mb_strlen($en_plate) == 13 && mb_strlen($en_plate) == 13) {
//                $lastplate = $plateNumber;
//            }else{
//                return $this->errorMsg('There is Error While Saving record',400);
//
//            }
//
//            $date = $data['date'];
//            $time = $data['time'];
//            $str_time = date('Y-m-d H:i:s', strtotime("$date $time"));
//            $branch_id = UserModelBranch::find($data['user_model_branch_id'])->branch_id;
//
//            $profile = Carprofile::where('BayCode',$data['area'])
//                ->where('status','pending')
//                ->where('branch_id', $branch_id)
//                ->whereDate('checkInDate', '<=',$str_time)
//                ->latest()->first();
//            if($profile){
//                $profile->update([
//                    'plateNumber' => $lastplate,
//                    'screenshot'=>$data['screenshot']
//                ]);
//            }else {
//                Carprofile::create([
//                    'status'=>'pending',
//                    'area_screenshot'=>$data['screenshot'],
//                    'plateNumber' => $lastplate,
//                    'BayCode'=>$data['area'],
//                    'checkInDate'=> $str_time,
//                    'branch_id'=> $branch_id,
//                ]);
//
//            }
//
////            $new_data = Arr::except($data, ['plate_no']);
////            $new_data['plate_no'] = $lastplate;
////            $insert=CarPLates::create($new_data);
//            $insert=CarPLates::create($data);
//
//            if($insert){
//                return response()->json([
//                    'success' => true,
//                    'message' => ' Data Inserted Successfully',
//                ]);
//            }else{
//                return $this->errorMsg('There is Error While Saving record',400);
//            }
//
//            DB::commit();
//        } catch (\Exception $e) {
//            DB::rollback();
//            return $this->errorMsg('There is Error While Saving record',400);
//        }
//    }

    public function saveCarPlatesRecord($data)
    {
        try {

            $plateNumber = $data['plate_no'];
            $date = $data['date'];
            $time = $data['time'];
            $str_time = date('Y-m-d H:i:s', strtotime("$date $time"));
            $branch_id = UserModelBranch::find($data['user_model_branch_id'])->branch_id;

            $plateService = new PlateServices();
            $plate = $plateService->resolvePlate($plateNumber);

            if ($plate == false) {
                return $this->errorMsg('car plate row not inserted due to upnoramal shape', 400);
            }

            $profile = Carprofile::where('BayCode', $data['area'])
                ->where('status', 'pending')
                ->where('branch_id', $branch_id)
                ->latest()->first();

            $areaStatus = AreaStatus::where('area', $data['area'])
                ->where('branch_id', $branch_id)
                ->latest()->first();

            if ($profile) {
                $latest = Carprofile::where('BayCode', $data['area'])
                    ->where('status', 'completed')
                    ->where('plate_status', 'success')
                    ->where('branch_id', $branch_id)
                    ->whereDate('checkInDate', now()->toDateString())
                    ->latest()
                    ->first();

                if ($latest) {

                    if ($latest->plate_en == $plate['plate_en']['plate'] || $latest->plate_ar == $plate['plate_ar']['plate']) {
                        @unlink(storage_path("app/public" . $profile->screenshot));
                        $profile->delete();
                        $latest->update([
                            'checkOutDate' => $str_time,
                        ]);

                    } elseif ($latest->char_en == $plate['plate_en']['char'] || $latest->char_ar == $plate['plate_ar']['char']) {
                        @unlink(storage_path("app/public" . $profile->screenshot));
                        $profile->delete();
                        $number = $plateService->resolveNumber($latest->number_en, $plate['plate_en']['number']);
                        $result = ($number['number_en'] == $plate['plate_en']['number'] && $number['number_en'] != $latest->number_en) ? true : false;

                        if ($result) {
                            $latest->update([
                                'checkOutDate' => $str_time,
                                'plateNumber' => $plate['plate'],
                                'plate_ar' => $plate['plate_ar']['plate'],
                                'plate_en' => $plate['plate_en']['plate'],
                                'plate_status' => $plate['status'],
                            ]);

                        } else {
                            $latest->update([
                                'checkOutDate' => $str_time,
                            ]);

                        }
                    } elseif ($plate['status'] == 'error' && $plate['plate_en']['number'] == $latest->number_en && Str::contains(str_replace(' ', '', $plate['plate_en']['char']), str_replace(' ', '', $latest->char_en))) {
                        @unlink(storage_path("app/public" . $profile->screenshot));
                        $profile->delete();
                        $latest->update([
                            'checkOutDate' => $str_time,
                        ]);

                    } else {
                        if ($profile->plateNumber == null || $plate['status'] == 'success') {
                            $result = true;
                            if ($profile->char_en == $plate['plate_en']['char']) {
                                $number = $plateService->resolveNumber($profile->number_en, $plate['plate_en']['number']);
                                $result = ($number['number_en'] == $plate['plate_en']['number'] && $number['number_en'] != $profile->number_en) ? true : false;
                            }
                            if ($result) {
                                $profile->update([
                                    'welcome' => null,
                                    'plateNumber' => $plate['plate'],
                                    'plate_ar' => $plate['plate_ar']['plate'],
                                    'plate_en' => $plate['plate_en']['plate'],
                                    'plate_status' => $plate['status'],
                                    'screenshot' => $data['screenshot'],
                                    'disk' => 'local',

                                ]);
                                $areaStatus->last_plate = $plate['plate_en']['plate'];
                                $areaStatus->save();
                            }
                        }
                    }
                } else {
                    if ($profile->plateNumber == null || $plate['status'] == 'success') {
                        $result = true;
                        if ($profile->char_en == $plate['plate_en']['char']) {
                            $number = $plateService->resolveNumber($profile->number_en, $plate['plate_en']['number']);
                            $result = ($number['number_en'] == $plate['plate_en']['number'] && $number['number_en'] != $profile->number_en) ? true : false;
                        }
                        if ($result) {
                            $profile->update([
                                'welcome' => null,
                                'plateNumber' => $plate['plate'],
                                'plate_ar' => $plate['plate_ar']['plate'],
                                'plate_en' => $plate['plate_en']['plate'],
                                'plate_status' => $plate['status'],
                                'screenshot' => $data['screenshot'],
                                'disk' => 'local'
                            ]);
                            $areaStatus->last_plate = $plate['plate_en']['plate'];
                            $areaStatus->save();
                        }
                    }
                }
            } else {
                $check = Carprofile::where('BayCode', $data['area'])
                    ->where('branch_id', $branch_id)
                    ->whereDate('checkInDate', now()->toDateString())
                    ->latest()
                    ->first();

                if ($check) {
                    if ($check->status == 'completed') {
                        if ($check->plate_en == $plate['plate_en']['plate']) {
                            $check->update([
                                'checkOutDate' => $str_time
                            ]);
                        } elseif ($check->char_ar == $plate['plate_ar']['char'] || $check->char_en == $plate['plate_en']['char']) {

                            $number = $plateService->resolveNumber($check->number_en, $plate['plate_en']['number']);
                            $result = ($number['number_en'] == $plate['plate_en']['number'] && $number['number_en'] != $check->number_en) ? true : false;

                            if ($result) {
                                $check->update([
                                    'checkOutDate' => $str_time,
                                    'plateNumber' => $plate['plate'],
                                    'plate_ar' => $plate['plate_ar']['plate'],
                                    'plate_en' => $plate['plate_en']['plate'],
                                    'plate_status' => $plate['status'],
                                    'screenshot' => $data['screenshot'],
                                    'disk' => 'local'
                                ]);

                            } else {
                                $check->update([
                                    'checkOutDate' => $str_time,
                                ]);
                            }

                        } else {
                            if ($plate['status'] == 'success') {
                                Carprofile::create([
                                    'status' => 'pending',
                                    'screenshot' => $data['screenshot'],
                                    'plateNumber' => $plate['plate'],
                                    'plate_ar' => $plate['plate_ar']['plate'],
                                    'plate_en' => $plate['plate_en']['plate'],
                                    'plate_status' => $plate['status'],
                                    'BayCode' => $data['area'],
                                    'checkInDate' => $str_time,
                                    'branch_id' => $branch_id,
                                    'disk' => 'local'
                                ]);
                            }
                        }

                    } else {
                        if ($check->status == 'semi-completed' && $plate['status'] == 'success') {
                            $check->update([
                                'status' => 'completed',
                                'screenshot' => $data['screenshot'],
                                'plateNumber' => $plate['plate'],
                                'plate_ar' => $plate['plate_ar']['plate'],
                                'plate_en' => $plate['plate_en']['plate'],
                                'plate_status' => $plate['status'],
                                'checkOutDate' => $str_time,
                                'disk' => 'local'
                            ]);
                        }
                    }
                }
            }

            $insert = CarPLates::create($data);

//            dispatch(new SendWelcomeMessage($plate_en));

            if ($plate['status'] == 'error') {
                return response()->json([
                    'success' => false,
                    'message' => 'Car Plate Not Good',
                ]);
            }

            if ($insert) {
                return response()->json([
                    'success' => true,
                    'message' => ' Data Inserted Successfully',
                ]);
            } else {
                return $this->errorMsg('car plate row not inserted', 400);
            }


        } catch (\Exception $e) {

            return $this->errorMsg('Some thing went wrong', 400);
        }
    }


    public function saveRecieptionRecord($data)
    {
        try {
            $insert = Recieption::create($data);
            if ($insert) {
                return response()->json([
                    'success' => true,
                    'message' => ' Data Inserted Successfully',
                ]);
            } else {
                return $this->errorMsg('There is Error While Saving record', 400);
            }


        } catch (\Exception $e) {

            return $this->errorMsg('There is Error While Saving record', 400);
        }
    }

    public function savePeopleRecord($data)
    {
        try {
            $insert = PeopleCount::create($data);
            if ($insert) {
                return response()->json([
                    'success' => true,
                    'message' => ' Data Inserted Successfully',
                ]);
            } else {
                return $this->errorMsg('There is Error While Saving record', 400);
            }

        } catch (\Exception $e) {

            return $this->errorMsg('There is Error While Saving record', 400);
        }
    }

    public function saveCarCountRecord($data)
    {
        try {
            $insert = CarCount::create($data);
            if ($insert) {
                return response()->json([
                    'success' => true,
                    'message' => ' Data Inserted Successfully',
                ]);
            } else {
                return $this->errorMsg('There is Error While Saving record', 400);
            }

        } catch (\Exception $e) {
            return $this->errorMsg('There is Error While Saving record', 400);
        }
    }

    public function saveEmotionRecord($data)
    {
        try {
            $insert = Emotion::create($data);
            if ($insert) {
                return response()->json([
                    'success' => true,
                    'message' => ' Data Inserted Successfully',
                ]);
            } else {
                return $this->errorMsg('There is Error While Saving record', 400);
            }


        } catch (\Exception $e) {
            return $this->errorMsg('There is Error While Saving record', 400);
        }
    }

    public function saveMaskRecord($data)
    {
        try {
            $insert = Mask::create($data);
            if ($insert) {
                return response()->json([
                    'success' => true,
                    'message' => ' Data Inserted Successfully',
                ]);
            } else {
                return $this->errorMsg('There is Error While Saving record', 400);
            }


        } catch (\Exception $e) {
            return $this->errorMsg('There is Error While Saving record', 400);
        }
    }

    public function saveHeatMapRecord($data)
    {
        try {

            $insert = Heatmap::insert($data);
            if ($insert) {
                return response()->json([
                    'success' => true,
                    'message' => ' Data Inserted Successfully',
                ]);
            } else {
                return $this->errorMsg('There is Error While Saving record', 400);
            }


        } catch (\Exception $e) {

            return $this->errorMsg('There is Error While Saving record', 400);
        }
    }

//    public function savePlaceRecord($data)
//    {
//        try {
//            $date = $data['date'];
//            $time = $data['time'];
//            $str_time = date('Y-m-d H:i:s', strtotime("$date $time"));
//            $branch_id = UserModelBranch::find($data['user_model_branch_id'])->branch_id;
//            if($data['status'] == '1'){
//                Carprofile::create([
//                    'status'=>'pending',
//                    'area_screenshot'=>$data['screenshot'],
//                    'BayCode'=>$data['area'],
//                    'checkInDate'=> $str_time,
//                    'branch_id'=> $branch_id,
//                ]);
//            }else {
//               $profile = Carprofile::where('BayCode',$data['area'])
//                    ->where('status','pending')
//                    ->where('branch_id', $branch_id)
//                    ->whereDate('checkInDate', '<=',$str_time)
//                    ->latest()->first();
//               if($profile){
//                    if(is_null($profile->plateNumber)){
//                        $profile->update([
//                            'status'=>'semi-completed',
//                            'checkOutDate'=> $str_time
//                        ]);
//                    } else {
//                        $profile->update([
//                            'status'=>'completed',
//                            'checkOutDate'=> $str_time
//                        ]);
//                    }
//               }
//
//            }
//
//
//            $insert=PlaceMaintenance::create($data);
//            if($insert){
//                return response()->json([
//                    'success' => true,
//                    'message' => 'Data Inserted Successfully',
//                ]);
//            }else{
//                return $this->errorMsg('There is Error While Saving record',400);
//            }
//
//            DB::commit();
//        } catch (\Exception $e) {
//            DB::rollback();
//            return $this->errorMsg('There is Error While Saving record',400);
//        }
//    }

    public function savePlaceRecord($data)
    {
        try {
            $date = $data['date'];
            $time = $data['time'];
            $str_time = date('Y-m-d H:i:s', strtotime("$date $time"));
            $branch_id = UserModelBranch::find($data['user_model_branch_id'])->branch_id;

            $profile = Carprofile::where('BayCode', $data['area'])
                ->where('status', 'pending')
                ->where('branch_id', $branch_id)
                ->whereDate('checkInDate', '<=', $str_time)
                ->latest()->first();

            if ($data['status'] == '1') {
                if (!$profile) {
                    Carprofile::create([
                        'status' => 'pending',
                        'area_screenshot' => $data['screenshot'],
                        'BayCode' => $data['area'],
                        'checkInDate' => $str_time,
                        'branch_id' => $branch_id,
                    ]);
                }

            } else {
                if ($profile) {
                    if (is_null($profile->plateNumber)) {
                        $profile->update([
                            'status' => 'semi-completed',
                            'checkOutDate' => $str_time
                        ]);
                    } else {
                        $profile->update([
                            'status' => 'completed',
                            'checkOutDate' => $str_time
                        ]);
                    }
                }
            }

            $insert = PlaceMaintenance::create($data);

            if ($insert) {

                AreaStatus::updateOrCreate([
                    'area' => $data['area'],
                    'branch_id' => $branch_id,
                ], [
                    'status' => $data['status'],
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Data Inserted Successfully',
                ]);

            } else {
                return $this->errorMsg('There is Error While Saving record', 400);
            }

        } catch (\Exception $e) {
            return $this->errorMsg($e->getMessage() . 'There is Error While Saving record', 400);
        }
    }


}
