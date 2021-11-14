<?php

namespace App\Services;


use App\Models\AreaDurationDay;
use App\Models\AreaStatus;
use App\Models\PlaceMaintenance;
use App\Models\UserModelBranch;
use Illuminate\Support\Facades\Log;

class AreaDurationDaily
{
    /**
     * @param $date
     * @return bool
     */
    public function calculate($date): bool
    {
        try {
            $usersmodelsbranch = UserModelBranch::with('branch')->get();

            foreach ($usersmodelsbranch as $usermodelbranch) {

                $areas_query = AreaStatus::where('branch_id', $usermodelbranch->branch->id ?? '')->distinct()->pluck('area');

                if ($areas_query->isEmpty()) continue;

                $areas = $areas_query->sort()->toArray();

                $status = PlaceMaintenance::where('user_model_branch_id', $usermodelbranch->id)->get();

                if ($status->isEmpty()) continue;

                foreach ($areas as $area) {
                    $i = 0;
                    $areabusydura = 0;
                    $areaavildura = 0;

                    $check = PlaceMaintenance::where('user_model_branch_id', $usermodelbranch->id)
                        ->where('area', $area)
                        ->where('active', 1)
                        ->first();

                    if ($check == null) continue;

                    $status = PlaceMaintenance::where('user_model_branch_id', $usermodelbranch->id)
                        ->where('date', $date)
                        ->where('area', $area)
                        ->where('active', 1)
                        ->chunk(500, function ($places) use ($i, &$areabusydura, &$areaavildura, &$lastId) {
                            $laces = $places;
                            $records = $laces->groupBy('area');
                            foreach ($records as $key => $record) {
                                foreach ($record as $item) {
                                    if ($i > 0) {
                                        if ($record[$i - 1]->date == $item->date) {
                                            $time1 = strtotime($record[$i - 1]->time);
                                            $time2 = strtotime($item->time);
                                            $difference = round(abs($time2 - $time1) / 60); // in minutes
                                            if ($record[$i - 1]->status == 0) { //it was available
                                                $areaavildura += $difference;
                                            } elseif ($record[$i - 1]->status == 1) {//it was two person
                                                $areabusydura += $difference;
                                            }
                                        }
                                    }

                                    $i++;

                                } // end inner foreach
                            }
                        });

                    if ($areaavildura == 0 && $areabusydura == 0) {
                        continue;
                    }

                    AreaDurationDay::updateOrCreate([
                        'branch_id' => $usermodelbranch->branch->id,
                        'area' => $area,
                        'date' => $date
                    ], [
                        'work_by_minute' => $areaavildura,
                        'empty_by_minute' => $areabusydura,
                    ]);
                }
            }
            return true;

        } catch (Exception $e) {
            Log::error($e->getMessage() . $e->getLine());
        }
    }

}
