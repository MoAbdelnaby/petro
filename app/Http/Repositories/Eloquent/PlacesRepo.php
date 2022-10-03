<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\PlacesRepoInterface;
use App\Models\AreaDuration;
use App\Models\AreaDurationDay;
use App\Models\AreaStatus;
use App\Models\PlaceMaintenance;
use App\Models\PlaceMaintenanceSetting;
use App\Models\UserModel;
use App\Models\Branch;
use App\Models\UserModelBranch;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlacesRepo extends AbstractRepo implements PlacesRepoInterface
{
    public function __construct()
    {
        parent::__construct(PlaceMaintenance::class);
    }

    public function getUserModels()
    {
        $userModels = UserModel::with('model')->where('user_id', parentID())->where('active', 1)->orderBy('model_id', 'asc')->get();
        return $userModels;
    }

    public function getUserBranchModels($usermodelbranchid)
    {
        $userModels = UserModel::with('model')->where('branch_id', $usermodelbranchid)->where('active', 1)->orderBy('model_id', 'asc')->get();
        return $userModels;
    }

    public function getUserBranches()
    {
        $userBranches = Branch::has('models')->where('user_id', parentID())->where('active', 1)->orderBy('id', 'asc')->get();
        return $userBranches;
    }

    public function getRecordsByUserModelId($usermodelbranchid, $start, $end, $starttime = null, $endtime = null)
    {

        return $this->getData($usermodelbranchid, $start, $end, $starttime, $endtime);
        //try to get it in  range of start date ,end date ,pagination

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

    public function getNewData($usermodelbranh, $start, $end, $starttime = null, $endtime = null)
    {
        if (!$usermodelbranh instanceof UserModelBranch) {
            $usermodelbranh = UserModelBranch::whereId($usermodelbranh)->with('branch')->first();
        }

        $modelrecords = $this->model->where('user_model_branch_id', $usermodelbranh->id)->where('active', 1);
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

        $result["query"] = $modelrecords;

        $areas_all = AreaStatus::where('branch_id', $usermodelbranh->branch->id)->distinct()->get();

        $data = $modelrecords;
        $result['all_areas'] = $areas_all;
        $result['active_areas'] = $areas_all->pluck('area')->sort()->toArray();

//        $area_duration = AreaDuration::where('branch_id', $usermodelbranh->branch->id)->select('*');

//        if ($start != null || $end != null) {

            $query = AreaDurationDay::where('branch_id', $usermodelbranh->branch->id);

            if ($start) {
                $query = $query->whereDate('date', '>=', now()->toDateString());
            }
            if ($end) {
                $query = $query->whereDate('date', '<=',  now()->toDateString());
            }

            $area_duration = $query->select('area',
                DB::raw('SUM(work_by_minute) as work_by_minute'),
                DB::raw('SUM(empty_by_minute) as empty_by_minute')
            );
//        }


        $area_duration = $area_duration
            ->groupBy('area')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item['area'] => $item];
            });

        foreach ($areas_all->groupBy('area') as $key => $area) {

            $result['areas'][$key]['areabusydura'] = isset($area_duration[$key])
                ? round($area_duration[$key]['work_by_minute'] / 60) : 0;

            $result['areas'][$key]['areaavildura'] = isset($area_duration[$key])
                ? round($area_duration[$key]['empty_by_minute'] / 60) : 0;

            $result['areas'][$key]['areaavailable'] = $area[0];
        }

        $result["data"] = $data->orderBy('id', 'DESC')->paginate(10);
        $result["count"] = $result['data']->total();
        $result["status"] = true;

        return $result;
    }

    public function getRecordsByUserModelIdexport($usermodelbranchid, $start, $end, $starttime = null, $endtime = null)
    {

        return $this->getDataexport($usermodelbranchid, $start, $end, $starttime, $endtime);
        //try to get it in  range of start date ,end date ,pagination
    }

    public function getFiles($branchid, $usermodelbranchid)
    {

        return [];
    }

    private function getDataexport($usermodelbranchid, $start, $end, $starttime = null, $endtime = null)
    {

        $modelrecordsfilter = $this->model->select('id', 'date')->where('user_model_branch_id', $usermodelbranchid)->where('active', 1);

        if ($start) {
            $modelrecordsfilter = $modelrecordsfilter->whereDate('date', ' >= ', $start);
        }
        if ($end) {
            $modelrecordsfilter = $modelrecordsfilter->whereDate('date', ' <= ', $end);
        }
        if ($starttime) {
            $modelrecordsfilter = $modelrecordsfilter->where('time', ' >= ', $starttime);
        }
        if ($endtime) {
            $modelrecordsfilter = $modelrecordsfilter->where('time', ' <= ', $endtime);
        }
        $modelrecordsfilter = $modelrecordsfilter->get()->groupBy(function ($date) {
            //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
            return Carbon::parse($date->date)->format('m'); // grouping by months
        });

        $result["status"] = true;
        $result["count"] = $modelrecordsfilter->count();
        $result["list"] = $modelrecordsfilter;
        return $result;
    }

    public function getUserShiftSettingByUserModel($usermodelbranchid)
    {

        $lastsetting = PlaceMaintenanceSetting::where('user_model_branch_id', $usermodelbranchid)->where('active', 1)->first();
        if (!$lastsetting) {
            $screen = false;
            $notify = false;
            $usermodel = UserModelBranch::find($usermodelbranchid)->usermodel;

            $modelfeatures = json_decode($usermodel->features);
            foreach ($modelfeatures as $modelfeature) {
                if ($modelfeature == 9) {
                    $screen = true;
                }
                if ($modelfeature == 10) {
                    $notify = true;
                }
            }

            $now = date('Y-m-d');
            //insert first record as default
            $insert = PlaceMaintenanceSetting::Create(
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
            $lastsetting = PlaceMaintenanceSetting::where('user_model_branch_id', $usermodelbranchid)->where('active', 1)->first();

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
                        return redirect()->route('branchmodelpreview.places', [$branch, $usermodelbranchid])->with('success', 'data Updated successfully');

                    } else {
                        return redirect()->route('places.index', [$usermodelbranchid])->with('success', 'data Updated successfully');
                    }


                } else {
                    $lastsetting->active = false;
                    $lastsetting->save();

                }
            }

            $insert = PlaceMaintenanceSetting::Create(
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
                    return redirect()->route('branchmodelpreview.places', [$branch, $usermodelbranchid])->with('success', 'data Updated successfully');

                } else {
                    return redirect()->route('places.index', [$usermodelbranchid])->with('success', 'data Updated successfully');
                }


            } else {
                DB::rollback();
                if (in_array('branch', explode('/', url()->previous()))) {
                    return redirect()->route('branchmodelpreview.places', [$branch, $usermodelbranchid])->with('danger', 'something went wrong');

                } else {
                    return redirect()->route('places.index', [$usermodelbranchid])->with('danger', 'something went wrong');
                }

            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            if (in_array('branch', explode('/', url()->previous()))) {
                return redirect()->route('branchmodelpreview.places', [$branch, $usermodelbranchid])->with('danger', 'something went wrong');

            } else {
                return redirect()->route('places.index', [$usermodelbranchid])->with('danger', 'something went wrong');
            }

            // Handle errors
        }
    }


}
