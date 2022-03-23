<?php

namespace App\Services\Report\type;

use App\Models\AreaDurationDay;
use App\Models\AreaStatus;
use App\Models\Branch;
use App\Models\CarPLatesSetting;
use App\Models\Carprofile;
use App\Models\PlaceMaintenanceSetting;
use App\Models\UserModelBranch;
use App\Services\Report\BaseReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use JsonException;

class PlaceReport extends BaseReport
{
    public $query;
    public string $mainTable = "area_duration_days";

    public function getCityQuery($list)
    {
        $query = DB::table($this->mainTable)
            ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
            ->join("regions", "regions.id", '=', "branches.region_id")
            ->join("regions as city", "city.id", '=', "regions.parent_id")
            ->where("branches.user_id", '=', parentID())
            ->where("regions.user_id", '=', parentID())
            ->where("branches.active", '=', true)
            ->where("regions.active", '=', true)
            ->whereIn("regions.parent_id", $list)
            ->select("city.id as list_id", "city.name as list_name",
                DB::raw("SUM($this->mainTable.work_by_minute) as work"),
                DB::raw("SUM($this->mainTable.empty_by_minute) as empty")
            );
        $this->query = $query;
    }

    public function getRegionQuery($list)
    {
        $query = DB::table($this->mainTable)
            ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
            ->join("regions", "regions.id", '=', "branches.region_id")
            ->where("branches.user_id", '=', parentID())
            ->where("regions.user_id", '=', parentID())
            ->where("branches.active", '=', true)
            ->where("regions.active", '=', true)
            ->whereIn("regions.id", $list)
            ->select("regions.id as list_id", "regions.name as list_name",
                DB::raw("SUM($this->mainTable.work_by_minute) as work"),
                DB::raw("SUM($this->mainTable.empty_by_minute) as empty")
            );
        $this->query = $query;
    }

    public function getBranchQuery($list)
    {
        $query = DB::table($this->mainTable)
            ->whereIn("branch_id", $list)
            ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
            ->where("branches.user_id", '=', parentID())
            ->where("branches.active", '=', true)
            ->select("branch_id as list_id", "branches.name as list_name",
                DB::raw("SUM(work_by_minute) as work"),
                DB::raw("SUM(empty_by_minute) as empty")
            );

        $this->query = $query;
    }

    public function getAreaQuery($list)
    {
        $query = DB::table($this->mainTable)
            ->whereIn("$this->mainTable.branch_id", $list)
            ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
            ->where("branches.user_id", '=', parentID())
            ->where("branches.active", '=', true)
            ->select("$this->mainTable.area as list_id", "$this->mainTable.area as list_name",
                DB::raw("SUM(work_by_minute) as work"),
                DB::raw("SUM(empty_by_minute) as empty")
            );

        $this->query = $query;
    }

    /**
     * @param $key
     * @param $filter
     * @return array
     * @throws JsonException
     */
    public function getReport($key, $filter): array
    {
        $filter["column"] = "$this->mainTable.date";

        $query = $this->handleDateFilter($this->query, $filter);

        $result = json_decode($query->groupBy("list_id")
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->list_name => $item];
            }), true, 512, JSON_THROW_ON_ERROR);

        $report['charts'] = $this->prepareChart($result, $key);
        $report["info"] = [
            "list" => ucfirst($key),
            "unit" => "Hours",
            "columns" => ["work", "empty"],
            "display_key" => ["work" => __('app.work_duration'), "empty" => __('app.empty_duration')]
        ];

        return $report;
    }

    /**
     * Prepare Format of Place Data Chart
     *
     * @param $data
     * @param string $key_name
     * @return array
     */
    public function prepareChart($data, string $key_name = "list"): array
    {
        $charts = [];
        $filter_key = '';
        if ($key_name == "area") {
            $filter_key = 'Area# ';
        } elseif ($key_name == 'compare_area') {
            $filter_key = 'Area# ';
        }

        if (count(array_filter(array_values($data))) > 0) {
            $i = 0;
            foreach ($data as $key => $value) {
                $charts["bar"][$i]['list'] = $filter_key . $key;
                $charts["bar"][$i]["work"] = round($value["work"] / 60);
                $charts["bar"][$i]["empty"] = round($value["empty"] / 60);
                $charts["circle"]["work"][$i]['list'] = $filter_key . $key;
                $charts["circle"]["work"][$i]["value"] = round($value["work"] / 60);
                $charts["circle"]["empty"][$i]['list'] = $filter_key . $key;
                $charts["circle"]["empty"][$i]["value"] = round($value["empty"] / 60);
                $i++;
            }
        }

        return $charts;
    }

    /**
     * @param $filter
     * @return array
     * @throws JsonException
     */
    protected function loadDownloadReport($filter): array
    {
        $data = $this->handleListQuery($filter);
        $func_name = "get" . ucfirst($data["type"]) . "Query";
        $list = $data["list"];

        if (!is_array($list)) {
            $list = \Arr::wrap(str_contains($list, ',') ? explode(',', $list) : $list);
        }

        $this->$func_name($list);

        return [$this->getReport($data["type"], $filter)['charts']['bar']];
    }


    /**
     * @param $filter
     * @param $lists
     * @return array
     */
    public function handleDurationCustom($filter, $lists = null): array
    {
        $work = 0;
        $empty = 0;

        if (empty($lists)) {
            $lists = Branch::primary()->active()->pluck('id')->toArray();
        }

        if (!is_array($lists)) {
            $lists = str_contains($lists, ',') ? explode(',', (string)$lists) : $lists;
        }

        foreach (\Arr::wrap($lists) as $branch) {
            $areas = AreaStatus::where('branch_id', $branch)->distinct()->pluck('area');
            if ($areas->isEmpty()) continue;
            $areas = $areas->sort()->toArray();

            foreach ($areas as $area) {
                $branch_work = 0;
                $query = Carprofile::where('status', 'completed')
                    ->where('branch_id', $branch)
                    ->where('BayCode', $area);

                //Handle date filter by checkInDate
                $filter['column'] = 'checkInDate';
                $this->handleDateFilter($query, $filter, true);

                $query->chunk(500, function ($profiles) use (&$work, &$branch_work) {
                    foreach ($profiles as $record) {
                        $start = Carbon::parse($record->checkInDate);
                        $end = Carbon::parse($record->checkOutDate);
                        if ($end > $start) {
                            $difference = $end->diffInMinutes($start);
                            $branch_work += $difference;
                            $work += $difference;
                        }
                    }
                });

                $user_model_branch = UserModelBranch::with('branch')->where('branch_id', $branch)->latest()->first();
                $plate_setting = PlaceMaintenanceSetting::where('user_model_branch_id', $user_model_branch->id)->where('active', 1)->first();
                if (!$plate_setting) {
                    $plate_setting = CarPLatesSetting::where('user_model_branch_id', $user_model_branch->id)->where('active', 1)->first();
                }

                $start_time = Carbon::parse($filter['start']);
                $start_time_setting = Carbon::parse($plate_setting->start_time);
                $end_time = Carbon::parse($filter['end']);
                $end_time_setting = Carbon::parse($plate_setting->end_time);

                if($start_time->format('H') < $start_time_setting->format('H') ){
                    $start_time = $start_time_setting;
                }

                if($end_time->format('H') < $end_time_setting->format('H') ){
                    $end_time = $end_time_setting;
                }

                if ($end_time < $start_time) {
                    $end_time = Carbon::now();
                }

                $branch_empty = $end_time->diffInMinutes($start_time);

                if ($branch_empty > $branch_work) {
                    $branch_empty = $branch_empty - $branch_work;
                }
                $empty += $branch_empty ?? 0;
            }
        }

        return [$work, $empty];
    }

    /**
     * @param $filter
     * @param $type
     * @param null $lists
     * @return int|mixed
     */
    public function handleDurationDay($filter, $type, $lists = null)
    {
        $query = AreaDurationDay::query();

        $filter['column'] = 'date';
        $this->handleDateFilter($query, $filter);

        if (!empty($lists)) {
            if (!is_array($lists)) {
                $lists = str_contains($lists, ',') ? explode(',', (string)$lists) : $lists;
            }
            $lists = \Arr::wrap($lists);

            $query->whereIn('branch_id', $lists);

        }

        return $query->sum("{$type}_by_minute");
    }
}
