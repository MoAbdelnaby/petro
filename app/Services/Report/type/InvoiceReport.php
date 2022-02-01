<?php

namespace App\Services\Report\type;

use App\Services\Report\BaseReport;
use Illuminate\Support\Facades\DB;
use JsonException;

class InvoiceReport extends BaseReport
{
    public $query;
    public string $mainTable = "carprofiles";

    public function getCityQuery($list)
    {
        foreach (['invoice', 'no_invoice'] as $type) {
            $query[$type] = DB::table($this->mainTable)
                ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
                ->join("regions", "regions.id", '=', "branches.region_id")
                ->join("regions as city", "city.id", '=', "regions.parent_id")
                ->where("$this->mainTable.invoice", $type == 'invoice' ? '<>' : '=', null)
                ->where("$this->mainTable.status", '=', 'completed')
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
                ->where("$this->mainTable.status", '=', 'completed')
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
                ->where("$this->mainTable.status", '=', 'completed')
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
                ->whereIn("$this->mainTable.branch_id", $list)
                ->where("$this->mainTable.status", '=', 'completed')
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
                ->mapWithKeys(function ($item) {
                    return [$item->list_name => $item];
                }), true, 512, JSON_THROW_ON_ERROR);
        }

        $result = array_merge_recursive_distinct($result['invoice'], $result['no_invoice']);
        $report = $this->prepareChart($result, $key);
        $report["branch_check"] = $this->handleReportCompare($filter);
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
                $charts["bar"][$i]["invoice"] = round($value["invoice"] ?? 0 / 60);
                $charts["bar"][$i]["no_invoice"] = round($value["no_invoice"] ?? 0 / 60);
                $charts["circle"]["invoice"][$i]['list'] = $filter_key . $key;
                $charts["circle"]["invoice"][$i]["value"] = round($value["invoice"] ?? 0 / 60);
                $charts["circle"]["no_invoice"][$i]['list'] = $filter_key . $key;
                $charts["circle"]["no_invoice"][$i]["value"] = round($value["no_invoice"] ?? 0 / 60);
                $i++;
            }
        }

        return $charts;
    }

    /**
     * @param $filter
     * @return array
     */
    public function handleReportCompare($filter): array
    {
        $result = [];
        foreach (['invoice', 'no_invoice'] as $status) {
            $query[$status] = DB::table($this->mainTable)
                ->where("$this->mainTable.status", '=', 'completed')
                ->select('branches.id')
                ->join('branches', 'branches.id', '=', "$this->mainTable.branch_id")
                ->where('branches.user_id', parentID())
                ->where('branches.active', true)
                ->whereNull('branches.deleted_at')
                ->distinct();

            $query[$status] = $this->handleDateFilter($query[$status], $filter, true);

            if ($status == 'no_invoice') {
                $result[$status] = $query[$status]->whereNull('invoice')->get()->toArray();
            } else {
                $result[$status] = $query[$status]->whereNotNull('invoice')->get()->toArray();
            }
        }

        $invoices = array_column($result['invoice'], 'id');
        $no_invoices = array_column($result['no_invoice'], 'id');
        $no_invoices = array_values(array_diff($no_invoices, $invoices));
        $result['invoice'] = count($invoices);
        $result['no_invoice'] = count($no_invoices);

        return $result;
    }
}
