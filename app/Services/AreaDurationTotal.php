<?php

namespace App\Services;


use App\Models\AreaDuration;
use App\Models\AreaDurationDay;
use App\Models\AreaStatus;
use App\Models\PlaceMaintenance;
use App\Models\UserModelBranch;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use DB;

class AreaDurationTotal
{

    /**
     * @return bool
     */
    public function calculate(): bool
    {
        try {

            $query = AreaDurationDay::select([
                'area',
                'branch_id',
                DB::raw("SUM(empty_by_minute) as total_empty_by_minute"),
                DB::raw("SUM(work_by_minute) as total_work_by_minute")
            ]);

            if (!$_ENV['AREA_STATUS_FIRST_UPDATE']) {
                $query->whereDate('date', '>=', Carbon::now()->toDateString());
            }

            $results = $query->groupBy(['branch_id', 'area'])->get();

            foreach ($results as $result) {

                AreaDuration::updateOrCreate([
                    'branch_id' => $result->branch_id,
                    'area' => $result->area
                ], [
                    'work_by_minute' => $result->total_work_by_minute,
                    'empty_by_minute' => $result->total_empty_by_minute,
                    'last_id' => 1,
                ]);
            }


//            $usersmodelsbranch = UserModelBranch::with('branch')->get();
//
//            foreach ($usersmodelsbranch as $usermodelbranch) {
//
//                $areas_query = AreaStatus::where('branch_id', $usermodelbranch->branch->id ?? '')->distinct()->pluck('area');
//
//                if ($areas_query->isEmpty()) continue;
//
//                $areas = $areas_query->sort()->toArray();
//
//                $status = PlaceMaintenance::where('user_model_branch_id', $usermodelbranch->id)->get();
//
//                if ($status->isEmpty()) continue;
//
//                foreach ($areas as $area) {
//                    $i = 0;
//                    $areabusydura = 0;
//                    $areaavildura = 0;
//
//                    $area_duration = AreaDuration::where('branch_id', $usermodelbranch->branch->id)->where('area', $area)->first();
//                    $lastId = !is_null($area_duration) ? $area_duration->last_id : 0;
//                    $old_areaavildura = !is_null($area_duration) ? $area_duration->work_by_minute : 0;
//                    $old_areabusydura = !is_null($area_duration) ? $area_duration->empty_by_minute : 0;
//
//                    PlaceMaintenance::where('user_model_branch_id', $usermodelbranch->id)
//                        ->where('id', '>', $lastId)
//                        ->where('area', $area)
//                        ->where('active', 1)
//                        ->chunk(500, function ($places) use ($i, &$areabusydura, &$areaavildura, &$lastId) {
//                            $laces = $places;
//                            $records = $laces->groupBy('area');
//                            foreach ($records as $key => $record) {
//                                foreach ($record as $item) {
//                                    if ($i > 0) {
//                                        if ($record[$i - 1]->date == $item->date) {
//                                            $time1 = strtotime($record[$i - 1]->time);
//                                            $time2 = strtotime($item->time);
//                                            $difference = round(abs($time2 - $time1) / 60); // in minutes
//                                            if ($record[$i - 1]->status == 0) { //it was available
//                                                $areaavildura += $difference;
//                                            } elseif ($record[$i - 1]->status == 1) {//it was two person
//                                                $areabusydura += $difference;
//                                            }
//                                        }
//
//                                        $lastId = $item->id;
//                                    }
//
//                                    $i++;
//
//                                } // end inner foreach
//                            }
//                        });
//
//                    if ($areaavildura == 0 && $areabusydura == 0) {
//                        continue;
//                    }
//
//                    AreaDuration::updateOrCreate([
//                        'branch_id' => $usermodelbranch->branch->id,
//                        'area' => $area
//                    ], [
//                        'work_by_minute' => $areaavildura + $old_areaavildura,
//                        'empty_by_minute' => $areabusydura + $old_areabusydura,
//                        'last_id' => $lastId,
//                    ]);
//                }
//            }

            return true;

        } catch (Exception $e) {
            Log::error($e->getMessage() . $e->getLine());
        }
    }

}
