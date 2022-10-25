<?php

namespace App\Services\Report\type;

use App\Models\Branch;
use App\Services\Report\BaseReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use JsonException;

class InvoiceReport extends BaseReport
{
    public $query;
    public string $mainTable = "carprofiles";

    public function getCityQuery($list, $selectQuery = null): void
    {
        foreach (['invoice', 'no_invoice'] as $type) {
            $query[$type] = DB::table($this->mainTable)
                ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
                ->join("regions", "regions.id", '=', "branches.region_id")
                ->join("regions as city", "city.id", '=', "regions.parent_id")
                ->where("$this->mainTable.invoice", $type == 'invoice' ? '<>' : '=', null)
                ->where("$this->mainTable.status", '=', 'completed')
                ->where("$this->mainTable.plate_status", '=', 'success')
                ->where("branches.user_id", '=', parentID())
                ->where("regions.user_id", '=', parentID())
                ->where("branches.active", '=', true)
                ->where("regions.active", '=', true)
                ->whereIn("regions.parent_id", $list);

            if ($type == 'invoice' && !is_null($selectQuery)) {
                $query[$type]->selectRaw("city.id as list_id,city.name as list_name, $selectQuery");
            } else {
                $query[$type]->selectRaw("city.id as list_id,city.name as list_name,COUNT($this->mainTable.id) as $type");
            }
        }
        $this->query = $query;
    }

    public function getRegionQuery($list, $selectQuery = null): void
    {
        foreach (['invoice', 'no_invoice'] as $type) {
            $query[$type] = DB::table($this->mainTable)
                ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
                ->join("regions", "regions.id", '=', "branches.region_id")
                ->where("$this->mainTable.invoice", $type == 'invoice' ? '<>' : '=', null)
                ->where("$this->mainTable.status", '=', 'completed')
                ->where("$this->mainTable.plate_status", '=', 'success')
                ->where("branches.user_id", '=', parentID())
                ->where("regions.user_id", '=', parentID())
                ->where("branches.active", '=', true)
                ->where("regions.active", '=', true)
                ->whereIn("regions.id", $list);

            if ($type == 'invoice' && !is_null($selectQuery)) {
                $query[$type]->selectRaw("regions.id as list_id, regions.name as list_name, $selectQuery");
            } else {
                $query[$type]->selectRaw("regions.id as list_id, regions.name as list_name,COUNT($this->mainTable.id) as $type");
            }
        }

        $this->query = $query;
    }

    public function getBranchQuery($list, $selectQuery = null): void
    {
        foreach (['invoice', 'no_invoice'] as $type) {
            $query[$type] = DB::table($this->mainTable)
                ->whereIn("branch_id", $list)
                ->where("$this->mainTable.status", '=', 'completed')
                ->where("$this->mainTable.plate_status", '=', 'success')
                ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
                ->where("$this->mainTable.invoice", $type == 'invoice' ? '<>' : '=', null)
                ->where("branches.user_id", '=', parentID())
                ->where("branches.active", '=', true);

            if ($type == 'invoice' && !is_null($selectQuery)) {
                $query[$type]->selectRaw("branch_id as list_id,branches.name as list_name, $selectQuery");
            } else {
                $query[$type]->selectRaw("branch_id as list_id,branches.name as list_name,COUNT($this->mainTable.id) as $type");
            }
        }

        $this->query = $query;
    }

    public function getAreaQuery($list, $selectQuery = null): void
    {
        foreach (['invoice', 'no_invoice'] as $type) {
            $query[$type] = DB::table($this->mainTable)
                ->whereIn("$this->mainTable.branch_id", $list)
                ->where("$this->mainTable.status", '=', 'completed')
                ->where("$this->mainTable.plate_status", '=', 'success')
                ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
                ->where("$this->mainTable.invoice", $type == 'invoice' ? '<>' : '=', null)
                ->where("branches.user_id", '=', parentID())
                ->where("branches.active", '=', true);

            if ($type == 'invoice' && !is_null($selectQuery)) {
                $query[$type]->selectRaw("BayCode as list_id,BayCode as list_name, $selectQuery");
            } else {
                $query[$type]->selectRaw("BayCode as list_id,BayCode as list_name,COUNT($this->mainTable.id) as $type");
            }
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
        if ($filter['download'] ?? false) {
            return collect($this->query['invoice']->get())->groupBy("list_id")
                ->mapWithKeys(function ($item) use ($key) {
                    return [$item[0]->list_name => array_map(static function ($el) use ($key) {
                        return array_unique([
                            ucfirst($key) . " Name" => $el->list_name,
                            'Branch Name' => $el->branch_name,
                            'Area Name' => "Area# $el->BayCode",
                            'Plate En' => $el->plate_en,
                            'Plate Ar' => $el->plate_ar,
                            'CheckIn Date' => $el->checkInDate,
                            'CheckOutDate' => $el->checkOutDate,
                            'Duration' => str_replace('before', '', \Carbon\Carbon::parse($el->checkInDate)->diffForHumans($el->checkOutDate)),
                            'Invocie' => $el->invoice
                        ]);
                    }, $item->toArray())];
                })->toArray();
        }

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
        $report['charts'] = $this->prepareChart($result, $key);
        $report['branch_backout'] = $this->handleBranchBackout($filter);
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
     * @param string $type
     * @param string $type_column
     * @return array
     */
    public function handleReportCompare($filter, $type = 'count', $type_column = 'list'): array
    {
        $data = [];
        if (isset($filter['show_by'])) {
            $data = $this->handleListQuery($filter);
        }
        $list = $data['list'] ?? [];
        if (!is_array($list)) {
            $list = \Arr::wrap(str_contains($list, ',') ? explode(',', $list) : $list);
        }

        $result = [];
        foreach (['invoice', 'no_invoice'] as $status) {
            $query[$status] = DB::table($this->mainTable)
                ->where("$this->mainTable.status", '=', 'completed')
                ->where("$this->mainTable.plate_status", '=', 'success')
                ->select('branches.id')
                ->join('branches', 'branches.id', '=', "$this->mainTable.branch_id")
                ->where('branches.user_id', parentID())
                ->where('branches.active', true)
                ->whereNull('branches.deleted_at')
                ->distinct();

            if (auth()->user()->type === 'subcustomer') {
                $branches = Branch::active()->primary()
                    ->whereHas('branch_users', fn($q) => $q->where('user_id', auth()->id()))
                    ->pluck('id')
                    ->toArray();

                if ($filter['default']??false) {
                    $query[$status] = $query[$status]->whereIn('branches.id', $branches);
                }else{
                    $query[$status] = $query[$status]->whereIn('branches.id', $list);
                }

            }else{
                if ($data['type'] == 'branch' && !($filter['default'] ?? false)) {
                    $query[$status] = $query[$status]->whereIn('branches.id', $list);
                }
            }

            $filter['column'] = "$this->mainTable.checkInDate";

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

        if ($type === 'count') {
            $result['invoice'] = count($invoices);
            $result['no_invoice'] = count($no_invoices);

            return $result;
        }

        $ids = $type === 'invoice' ? $invoices : $no_invoices;

        if ($type_column === 'id') {
            return $ids;
        }

        return [
            'branch_check' => [
                'table' => Branch::select('id', 'name', 'code', 'area_count', 'created_at')
                    ->whereIn('id', $ids)->get()->toArray()
            ]
        ];
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

        $selectQuery = 'branches.name as branch_name,BayCode,plate_en,plate_ar,checkInDate,checkOutDate,invoice';

        $this->$func_name($list, $selectQuery);

        return $this->getReport($data["type"], $filter);
    }

    public function handleBranchBackout($filter): array
    {
        $data = [];
        if (isset($filter['show_by'])) {
            $data = $this->handleListQuery($filter);
        }
        $list = $data['list'] ?? [];
        if (!is_array($list)) {
            $list = \Arr::wrap(str_contains($list, ',') ? explode(',', $list) : $list);
        }

        $filter['column'] = "$this->mainTable.checkInDate";

        if (auth()->user()->type === 'subcustomer') {
            $branches = Branch::active()->primary()
                ->whereHas('branch_users', fn($q) => $q->where('user_id', auth()->id()))
                ->pluck('id')->toArray();
        } else {
            $branches = Branch::active()->primary()->pluck('id')->toArray();
        }

        $date = !empty($filter['end']) ? Carbon::parse($filter['end'])->format('Y-m-d') : Carbon::now()->format('Y-m-d');
        $query = DB::table($this->mainTable)
            ->whereIn("$this->mainTable.status", ['completed', 'modified'])
            ->where("$this->mainTable.plate_status", '=', 'success')
            ->join('branches', 'branches.id', '=', "$this->mainTable.branch_id")
            ->where('branches.user_id', parentID())
            ->where('branches.active', true)
            ->when(isset($filter['branch_data']),function ($q) use($filter){
//                return $q->where('station_code', Branch::find($filter['branch_data'])->code);
                return $q->where('branches.id', $filter['branch_data']);
            })
            ->whereDate("$this->mainTable.checkInDate", $date)
            ->whereNull('branches.deleted_at')
            ->whereIn('branches.id',$branches)
            ->distinct()
            ->select(
                'branches.name as branch_name',
                DB::raw("(DATE_FORMAT($this->mainTable.checkInDate, '%d-%m-%Y')) as day"),
                DB::raw("SUM(CASE WHEN ISNULL(invoice) then 1 ELSE 0 END) as backout"),
                DB::raw("COUNT(*) as total"),
            );

//        $this->handleDateFilter($query, $filter, true);
        $result = $query->groupBy('branch_name')->get()->toArray();

        return ['table' => $result];
    }
}

