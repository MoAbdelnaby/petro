<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\PlatesRepoInterface;
use App\Models\AreaStatus;
use App\Models\Branch;
use App\Models\CarPLates;
use App\Models\CarPLatesSetting;
use App\Models\Carprofile;
use App\Models\UserModel;
use App\Models\UserModelBranch;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PlatesRepo extends AbstractRepo implements PlatesRepoInterface
{
    public function __construct()
    {
        parent::__construct(CarPLates::class);
    }

    public function getUserModels()
    {
        $userModels = UserModel::with('model')
            ->where('user_id', parentID())
            ->where('active', 1)
            ->orderBy('model_id', 'asc')
            ->get();

        return $userModels;
    }

    public function getUserBranchModels($usermodelbranchid)
    {
        $userModels = UserModel::with('model')
            ->where('branch_id', $usermodelbranchid)
            ->where('active', 1)
            ->orderBy('model_id', 'asc')
            ->get();

        return $userModels;
    }

    public function getUserBranches()
    {
        $userBranches = Branch::has('models')
            ->where('user_id', parentID())
            ->where('active', 1)
            ->orderBy('id', 'asc')
            ->get();

        return $userBranches;
    }

    public function getRecordsByUserModelId($usermodelbranchid, $start, $end, $starttime = null, $endtime = null)
    {
        //try to get it in  range of start date ,end date ,pagination
        return $this->getData($usermodelbranchid, $start, $end, $starttime, $endtime);
    }

    private function getData($usermodelbranchid, $start, $end, $starttime = null, $endtime = null)
    {

        $modelrecords = $this->model->where('user_model_branch_id', $usermodelbranchid)->where('active', 1);
        if ($start) {
            $modelrecords = $modelrecords->whereDate('date', '>=', $start);
        }
        if ($end) {
            $modelrecords = $modelrecords->whereDate('date', '<=', $end);
        }
        if ($starttime) {
            $modelrecords = $modelrecords->where('time', '>=', $starttime);
        }
        if ($endtime) {
            $modelrecords = $modelrecords->where('time', '<=', $endtime);
        }

        $data = $modelrecords;
        $modelrecords = $modelrecords->get();

        $result["status"] = true;
        $result["count"] = $modelrecords->count();
        $result["list"] = $modelrecords;
        $result["area1"] = $modelrecords = $this->model->where('user_model_branch_id', $usermodelbranchid)->where('active', 1);
        if ($start) {
            $result["area1"] = $result["area1"]->whereDate('date', '>=', $start);
        }
        if ($end) {
            $result["area1"] = $result["area1"]->whereDate('date', '<=', $end);
        }
        if ($starttime) {
            $result["area1"] = $result["area1"]->where('time', '>=', $starttime);
        }
        if ($endtime) {
            $result["area1"] = $result["area1"]->where('time', '<=', $endtime);
        }
        $result["area1"] = $result["area1"]->where('area', 1)->get();


        $result["area2"] = $modelrecords = $this->model->where('user_model_branch_id', $usermodelbranchid)->where('active', 1);
        if ($start) {
            $result["area2"] = $result["area2"]->whereDate('date', '>=', $start);
        }
        if ($end) {
            $result["area2"] = $result["area2"]->whereDate('date', '<=', $end);
        }
        if ($starttime) {
            $result["area2"] = $result["area2"]->where('time', '>=', $starttime);
        }
        if ($endtime) {
            $result["area2"] = $result["area2"]->where('time', '<=', $endtime);
        }
        $result["area2"] = $result["area2"]->where('area', 2)->get();
        $result["area3"] = $modelrecords = $this->model->where('user_model_branch_id', $usermodelbranchid)->where('active', 1);
        if ($start) {
            $result["area3"] = $result["area3"]->whereDate('date', '>=', $start);
        }
        if ($end) {
            $result["area3"] = $result["area3"]->whereDate('date', '<=', $end);
        }
        if ($starttime) {
            $result["area3"] = $result["area3"]->where('time', '>=', $starttime);
        }
        if ($endtime) {
            $result["area3"] = $result["area3"]->where('time', '<=', $endtime);
        }
        $result["area3"] = $result["area3"]->where('area', 3)->get();
        $result["area4"] = $modelrecords = $this->model->where('user_model_branch_id', $usermodelbranchid)->where('active', 1);
        if ($start) {
            $result["area4"] = $result["area4"]->whereDate('date', '>=', $start);
        }
        if ($end) {
            $result["area4"] = $result["area4"]->whereDate('date', '<=', $end);
        }
        if ($starttime) {
            $result["area4"] = $result["area4"]->where('time', '>=', $starttime);
        }
        if ($endtime) {
            $result["area4"] = $result["area4"]->where('time', '<=', $endtime);
        }
        $result["area4"] = $result["area4"]->where('area', 4)->get();
        $result["data"] = $data->orderBy('id', 'DESC')->paginate(10);
        return $result;
    }

    public function getNewData($branch_id, $start, $end)
    {
        $result = [];

        $areas_query = AreaStatus::where('branch_id', $branch_id)->distinct()->pluck('area');
        $areas = $areas_query->sort()->toArray();

        $count_query = DB::table('carprofiles')
            ->select(DB::raw('count(id) as count ,BayCode'))
            ->where('status', 'completed')
            ->where('plate_status', '!=','error')
            ->where('branch_id', $branch_id);

        if ($start) {
            $count_query = $count_query->whereDate('checkInDate', '>=', $start);
        }

        if ($end) {
            $count_query = $count_query->whereDate('checkInDate', '<=', $end);
        }

        $count_areas = $count_query->groupBy('BayCode')->pluck('count' , 'BayCode');

        foreach($areas as $area){;
            $result['areas_count'][$area] = $count_areas[$area] ?? 0;
        }

        $query = Carprofile::with(['welcomeStatus','invoiceStatus'])->selectRaw('carprofiles.*')
            ->whereIn('status', ['completed','pending'])
            ->where('plate_status', '!=','error')
            ->where('branch_id', $branch_id);


        if ($start) {
            $query = $query->whereDate('checkInDate', '>=', $start);
        }
        if ($end) {
            $query = $query->whereDate('checkInDate', '<=', $end);
        }

        $query = $query->orderBy('checkInDate', 'desc');

        $list = $query;
        $result['data_count'] = $query->count();
        $result['data'] = $list->paginate(10);

        return $result;
    }

    public function getRecordsByUserModelIdexport($usermodelbranchid, $start, $end, $starttime = null, $endtime = null)
    {
        //try to get it in  range of start date ,end date ,pagination
        return $this->getDataexport($usermodelbranchid, $start, $end, $starttime, $endtime);
    }

    private function getDataexport($usermodelbranchid, $start, $end, $starttime = null, $endtime = null)
    {

        $modelrecordsfilter = $this->model->select('id', 'date')->where('user_model_branch_id', $usermodelbranchid)->where('active', 1);

        if ($start) {
            $modelrecordsfilter = $modelrecordsfilter->whereDate('date', '>=', $start);
        }
        if ($end) {
            $modelrecordsfilter = $modelrecordsfilter->whereDate('date', '<=', $end);
        }
        if ($starttime) {
            $modelrecordsfilter = $modelrecordsfilter->where('time', '>=', $starttime);
        }
        if ($endtime) {
            $modelrecordsfilter = $modelrecordsfilter->where('time', '<=', $endtime);
        }
        $modelrecordsfilter = $modelrecordsfilter->get()->groupBy(function ($date) {
            return Carbon::parse($date->date)->format('m'); // grouping by months
        });

        $result["status"] = true;
        $result["count"] = $modelrecordsfilter->count();
        $result["list"] = $modelrecordsfilter;
        return $result;
    }

    public function getUserShiftSettingByUserModel($usermodelbranchid)
    {

        $lastsetting = CarPLatesSetting::where('user_model_branch_id', $usermodelbranchid)->where('active', 1)->first();

        if (!$lastsetting) {
            $screen = false;
            $notify = false;
            $usermodel = UserModelBranch::find($usermodelbranchid)->usermodel;
            $modelfeatures = json_decode($usermodel->features);
            foreach ($modelfeatures as $modelfeature) {
                if ($modelfeature == 11) {
                    $screen = true;
                }
                if ($modelfeature == 12) {
                    $notify = true;
                }
            }

            $now = date('Y-m-d');

            $insert = CarPLatesSetting::Create( //insert first record as default
                [
                    'start_time' => '09:00',
                    'end_time' => '17:00',
                    'start_date' => date('Y-m-d'),
                    'end_date' => date('Y-m-d', strtotime($now . ' + 30 days')),
                    'notification' => $notify,
                    'screenshot' => $screen,
                    'notification_start' => '09:00',
                    'notification_end' => '10:00',
                    'active' => true,
                    'user_model_branch_id' => $usermodelbranchid
                ]);
            return $insert;
        }

        return $lastsetting;
    }

    public function shiftSettingSave($request, $usermodelbranchid)
    {
        $branch = UserModelBranch::find($usermodelbranchid)->branch_id;
        $input = $request->all();
        $request->notification ? $input['notification'] = true : $input['notification'] = false;
        $request->screenshot ? $input['screenshot'] = true : $input['screenshot'] = false;

        DB::beginTransaction();

        try {
            $lastsetting = CarPLatesSetting::where('user_model_branch_id', $usermodelbranchid)->where('active', 1)->first();

            if ($lastsetting) {
                if (
                    $lastsetting->start_time == $request->start_time &&
                    $lastsetting->end_time == $request->end_time &&
                    $lastsetting->start_date == date('Y-m-d', strtotime($request->start_date)) &&
                    $lastsetting->end_date == date('Y-m-d', strtotime($request->end_date))
                ) {
                    // here update data
                    $lastsetting->notification = $input['notification'];
                    $lastsetting->screenshot = $input['screenshot'];
                    $lastsetting->notification_start = $request->notification_start;
                    $lastsetting->notification_end = $request->notification_end;
                    $lastsetting->save();
                    DB::commit();
                    if (in_array('branch', explode('/', url()->previous()))) {
                        return redirect()->route('branchmodelpreview.plates', [$branch, $usermodelbranchid])->with('success', 'data Updated successfully');

                    } else {
                        return redirect()->route('plates.index', [$usermodelbranchid])->with('success', 'data Updated successfully');
                    }
                } else {
                    $lastsetting->active = false;
                    $lastsetting->save();
                }
            }


            $insert = CarPLatesSetting::Create(
                [
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'start_date' => date('Y-m-d', strtotime($request->start_date)),
                    'end_date' => date('Y-m-d', strtotime($request->end_date)),
                    'notification' => $input['notification'],
                    'screenshot' => $input['screenshot'],
                    'notification_start' => $request->notification_start,
                    'notification_end' => $request->notification_end,
                    'active' => true,
                    'user_model_branch_id' => $usermodelbranchid
                ]);

            if ($insert) {
                DB::commit();
                if (in_array('branch', explode('/', url()->previous()))) {
                    return redirect()->route('branchmodelpreview.plates', [$branch, $usermodelbranchid])->with('success', 'data Updated successfully');

                } else {
                    return redirect()->route('plates.index', [$usermodelbranchid])->with('success', 'data Updated successfully');
                }


            } else {
                DB::rollback();
                if (in_array('branch', explode('/', url()->previous()))) {
                    return redirect()->route('branchmodelpreview.plates', [$branch, $usermodelbranchid])->with('danger', 'something went wrong');

                } else {
                    return redirect()->route('plates.index', [$usermodelbranchid])->with('danger', 'something went wrong');
                }

            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            if (in_array('branch', explode('/', url()->previous()))) {
                return redirect()->route('branchmodelpreview.plates', [$branch, $usermodelbranchid])->with('danger', 'something went wrong');

            } else {
                return redirect()->route('plates.index', [$usermodelbranchid])->with('danger', 'something went wrong');
            }
        }
    }

}
