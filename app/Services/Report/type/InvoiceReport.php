<?php

namespace App\Services\Report\type;

use App\Services\Report\BaseReport;
use Illuminate\Support\Facades\DB;
use JsonException;

class InvoiceReport extends BaseReport
{
    public $query;
    public string $mainTable = "carprofiles";

    /**
     * @param $filter
     * @return array
     * @throws JsonException
     */
    public function prepare($filter): array
    {
        $data = $this->handleListQuery($filter);
        $key = ucfirst($data["type"]);
        $func_name = "get{$key}Query";

        //Prepare Base Query to get This report base On List Type
        $this->$func_name($data["list"]);

        $data["charts"] = $this->getReport($key, $filter);

        return $data;
    }

    public function getCityQuery($list)
    {
        foreach (['invoice', 'no_invoice'] as $type) {
            $query[$type] = DB::table($this->mainTable)
                ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
                ->join("regions", "regions.id", '=', "branches.region_id")
                ->join("regions as city", "city.id", '=', "regions.parent_id")
                ->where("$this->mainTable.invoice", $type == 'invoice' ? '<>' : '=', null)
                ->where("branches.user_id", '=', parentID())
                ->where("regions.user_id", '=', parentID())
                ->where("branches.active", '=', true)
                ->where("regions.active", '=', true)
                ->whereIn("regions.parent_id", $list)
                ->select("city.id as list_id", "city.name as list_name",
                    DB::raw("COUNT($this->mainTable.id) as $type"),
                );
        }
        $this->query = $query;
    }

    public function getRegionQuery($list)
    {
        foreach (['invoice', 'no_invoice'] as $type) {
            $query[$type] = DB::table($this->mainTable)
                ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
                ->join("regions", "regions.id", '=', "branches.region_id")
                ->where("$this->mainTable.invoice", $type == 'invoice' ? '<>' : '=', null)
                ->where("branches.user_id", '=', parentID())
                ->where("regions.user_id", '=', parentID())
                ->where("branches.active", '=', true)
                ->where("regions.active", '=', true)
                ->whereIn("regions.id", $list)
                ->select("regions.id as list_id", "regions.name as list_name",
                    DB::raw("COUNT($this->mainTable.id) as $type"),
                );
        }
        $this->query = $query;
    }

    public function getBranchQuery($list)
    {
        foreach (['invoice', 'no_invoice'] as $type) {
            $query[$type] = DB::table($this->mainTable)
                ->whereIn("branch_id", $list)
                ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
                ->where("$this->mainTable.invoice", $type == 'invoice' ? '<>' : '=', null)
                ->where("branches.user_id", '=', parentID())
                ->where("branches.active", '=', true)
                ->select("branch_id as list_id", "branches.name as list_name",
                    DB::raw("COUNT($this->mainTable.id) as $type"),
                );
        }
        $this->query = $query;
    }

    public function getAreaQuery($list)
    {
        foreach (['invoice', 'no_invoice'] as $type) {
            $query[$type] = DB::table($this->mainTable)
                ->where("$this->mainTable.branch_id", $list)
                ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
                ->where("$this->mainTable.invoice", $type == 'invoice' ? '<>' : '=', null)
                ->where("branches.user_id", '=', parentID())
                ->where("branches.active", '=', true)
                ->select("$this->mainTable.BayCode as list_id", "$this->mainTable.BayCode as list_name",
                    DB::raw("COUNT($this->mainTable.id) as $type"),
                );
        }
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
        foreach (['invoice', 'no_invoice'] as $type) {
            $filter["column"] = "$this->mainTable.checkInDate";
            $query = $this->handleDateFilter($this->query[$type], $filter, true);
            $result[$type] = json_decode($query->groupBy("list_id")
                ->get()
                ->mapWithKeys(function ($item) use ($filter) {
                    return [$item->list_name => $item];
                }), true);
        }

        $result = array_merge_recursive_distinct($result['invoice'], $result['no_invoice']);
        $report = $this->prepareChart($result, $key);
        $report["info"] = [
            "list" => ucfirst($key),
            "unit" => config('app.report.type.invoice.unit'),
            "columns" => config('app.report.type.invoice.data'),
            "display_key" => ["invoice" => __('app.Invoice'), "no_invoice" => __('app.no_invoice')]
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
    public static function prepareChart($data, string $key_name = "list"): array
    {
        $charts = [];
        $filter_key = '';
        if ($key_name == "Area") {
            $filter_key = 'Area# ';
        } elseif ($key_name == 'Compare_area') {
            $filter_key = 'Area# ';
        }

        if (count(array_filter(array_values($data))) > 0) {
            $i = 0;
            foreach ($data as $key => $value) {
                $charts["bar"][$i]['list'] = $filter_key . $key;
                $charts["bar"][$i]["invoice"] = round($value["invoice"] ?? 0 / 60);
                $charts["bar"][$i]["no_invoice"] = round($value["no_invoice"] ?? 0 / 60);
                $i++;
            }

            $k = 0;
            foreach ($data as $key => $value) {
                $charts["circle"]["invoice"][$k]['list'] = $filter_key . $key;
                $charts["circle"]["invoice"][$k]["value"] = round($value["invoice"] ?? 0 / 60);
                $k++;
            }

            $j = 0;
            foreach ($data as $key => $value) {
                $charts["circle"]["no_invoice"][$j]['list'] = $filter_key . $key;
                $charts["circle"]["no_invoice"][$j]["value"] = round($value["no_invoice"] ?? 0 / 60);
                $j++;
            }
        }


        return $charts;
    }
}
