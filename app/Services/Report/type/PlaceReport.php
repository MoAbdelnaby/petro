<?php

namespace App\Services\Report\type;

use App\Services\Report\BaseReport;
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
            ->where("$this->mainTable.branch_id", $list)
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

        $report = $this->prepareChart($result, $key);
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
}
