<?php

namespace App\Services\Report\type;

use App\Services\Report\BaseReport;
use Illuminate\Support\Facades\DB;
use JsonException;

class StayingAverageReport extends BaseReport
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
            ->whereIn("regions.parent_id", $list)
            ->where("$this->mainTable.status", '=', 'completed')->where("$this->mainTable.plate_status", '=', 'success')
            ->select("city.id as list_id", "city.name as list_name",
                DB::raw('round(AVG(TIMESTAMPDIFF(MINUTE,checkInDate,checkOutDate)),0) as duration')
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
            ->where("$this->mainTable.status", '=', 'completed')->where("$this->mainTable.plate_status", '=', 'success')
            ->select("regions.id as list_id", "regions.name as list_name",
                DB::raw('round(AVG(TIMESTAMPDIFF(MINUTE,checkInDate,checkOutDate)),0) as duration')
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
            ->where("$this->mainTable.status", '=', 'completed')->where("$this->mainTable.plate_status", '=', 'success')
            ->select("branch_id as list_id", "branches.name as list_name",
                DB::raw('round(AVG(TIMESTAMPDIFF(MINUTE,checkInDate,checkOutDate)),0) as duration')
            );

        $this->query = $query;
    }

    public function getAreaQuery($list)
    {
        $query = DB::table($this->mainTable)
            ->whereIn("$this->mainTable.branch_id", $list)            ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
            ->where("branches.user_id", '=', parentID())
            ->where("branches.active", '=', true)
            ->where("$this->mainTable.status", '=', 'completed')->where("$this->mainTable.plate_status", '=', 'success')
            ->select("$this->mainTable.BayCode as list_id", "$this->mainTable.BayCode as list_name",
                DB::raw('round(AVG(TIMESTAMPDIFF(MINUTE,checkInDate,checkOutDate)),0) as duration')
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
            ->mapWithKeys(function ($item) use ($filter) {
                return [$item->list_name => $item];
            }), true, 512, JSON_THROW_ON_ERROR);

        $report['charts'] = $this->prepareChart($result, $key);
        $report["info"] = [
            "list" => ucfirst($key),
            "unit" => config('app.report.type.stayingAverage.unit'),
            "columns" => config('app.report.type.stayingAverage.data'),
            "display_key" => ["value" => __('app.duration')]
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
        $i = 0;
        if (count(array_filter(array_values($data))) > 0) {
            foreach ($data as $key => $value) {
                $charts['bar'][$i]['list'] = $filter_key . ' ' . $key;
                $charts['bar'][$i]['value'] = $value['duration'];
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
}
