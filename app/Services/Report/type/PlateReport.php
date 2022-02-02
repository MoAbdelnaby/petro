<?php

namespace App\Services\Report\type;

use App\Services\Report\BaseReport;
use Illuminate\Support\Facades\DB;
use JsonException;

class PlateReport extends BaseReport
{
    public $query;
    public string $mainTable = "carprofiles";

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
            ->where("$this->mainTable.status", '=', 'completed')
            ->whereIn("regions.parent_id", $list)
            ->select("city.id as list_id", "city.name as list_name",
                DB::raw('COUNT(carprofiles.id) as count')
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
            ->where("$this->mainTable.status", '=', 'completed')
            ->where("regions.active", '=', true)
            ->whereIn("regions.id", $list)
            ->select("regions.id as list_id", "regions.name as list_name",
                DB::raw('COUNT(carprofiles.id) as count')
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
            ->where("$this->mainTable.status", '=', 'completed')
            ->select("branch_id as list_id", "branches.name as list_name",
                DB::raw('COUNT(carprofiles.id) as count')
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
            ->where("$this->mainTable.status", '=', 'completed')
            ->select("$this->mainTable.BayCode as list_id", "$this->mainTable.BayCode as list_name",
                DB::raw('COUNT(carprofiles.id) as count')
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
        $filter["column"] = "$this->mainTable.checkInDate";

        $query = $this->handleDateFilter($this->query, $filter, true);

        $result = json_decode($query->groupBy("list_id")
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->list_name => $item];
            }), true, 512, JSON_THROW_ON_ERROR);

        $report['charts'] = $this->prepareChart($result, $key);
        $report["info"] = [
            "list" => ucfirst($key),
            "unit" => config('app.report.type.plate.unit'),
            "columns" => config('app.report.type.plate.data'),
            "display_key" => ["value" => __('app.Car_Count')]
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

        $x = 0;
        if (count(array_filter(array_values($data))) > 0) {
            foreach ($data as $key => $value) {
                $charts['bar'][$x]['list'] = $filter_key . ' ' . $key;
                $charts['bar'][$x]['value'] = $value['count'];
                $x++;
            }
        }

        return $charts;
    }
}
