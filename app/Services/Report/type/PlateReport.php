<?php

namespace App\Services\Report\type;

use App\Models\Branch;
use App\Services\Report\BaseReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use JsonException;

class PlateReport extends BaseReport
{
    public $query;
    public string $mainTable = "carprofiles";

    public function __construct()
    {
        $this->selectQuery = 'COUNT(carprofiles.id) as count';
    }

    /**
     * @param $list
     * @param $selectQuery
     * @return void
     */
    public function getCityQuery($list, $selectQuery = null): void
    {
        $selectQuery = $selectQuery ?? $this->selectQuery;

        $query = DB::table($this->mainTable)
            ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
            ->join("regions", "regions.id", '=', "branches.region_id")
            ->join("regions as city", "city.id", '=', "regions.parent_id")
            ->where("branches.user_id", '=', parentID())
            ->where("regions.user_id", '=', parentID())
            ->where("branches.active", '=', true)
            ->where("regions.active", '=', true)
            ->where("$this->mainTable.status", '=', 'completed')
            ->where("$this->mainTable.plate_status", '=', 'success')
            ->whereIn("regions.parent_id", $list)
            ->selectRaw("city.id as list_id, city.name as list_name,$selectQuery");

        $this->query = $query;
    }

    /**
     * @param $list
     * @param $selectQuery
     * @return void
     */
    public function getRegionQuery($list, $selectQuery = null): void
    {
        $selectQuery = $selectQuery ?? $this->selectQuery;

        $query = DB::table($this->mainTable)
            ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
            ->join("regions", "regions.id", '=', "branches.region_id")
            ->where("regions.user_id", '=', parentID())
            ->where("regions.active", '=', true)
            ->where("branches.user_id", '=', parentID())
            ->where("branches.active", '=', true)
            ->where("$this->mainTable.status", '=', 'completed')
            ->where("$this->mainTable.plate_status", '=', 'success')
            ->whereIn("regions.id", $list)
            ->selectRaw("regions.id as list_id, regions.name as list_name, $selectQuery");

        $this->query = $query;
    }

    /**
     * @param $list
     * @param $selectQuery
     * @return void
     */
    public function getBranchQuery($list, $selectQuery = null): void
    {
        $selectQuery = $selectQuery ?? $this->selectQuery;

        $query = DB::table($this->mainTable)
            ->whereIn("carprofiles.branch_id", $list)
            ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
            ->leftJoin("backout_reasons", "backout_reasons.car_profile_id", '=', "$this->mainTable.id")
            ->leftJoin("message_logs", "message_logs.carprofile_id", '=', "$this->mainTable.id")
            ->where("message_logs.type", '=', 'invoice')
            ->where("branches.user_id", '=', parentID())
            ->where("branches.active", '=', true)
            ->where("$this->mainTable.status", '=', 'completed')
            ->where("$this->mainTable.plate_status", '=', 'success')
            ->selectRaw("carprofiles.branch_id as list_id,branches.name as list_name,backout_reasons.reason1,backout_reasons.reason2,backout_reasons.reason3,message_logs.fileUrl, $selectQuery");

        $this->query = $query;
    }

    /**
     * @param $list
     * @param $selectQuery
     * @return void
     */
    public function getAreaQuery($list, $selectQuery = null): void
    {
        $selectQuery = $selectQuery ?? $this->selectQuery;

        $query = DB::table($this->mainTable)
            ->whereIn("$this->mainTable.branch_id", $list)
            ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
            ->leftJoin("backout_reasons", "backout_reasons.car_profile_id", '=', "$this->mainTable.id")
            ->leftJoin("message_logs", "message_logs.carprofile_id", '=', "$this->mainTable.id")
            ->where("message_logs.type", '=', 'invoice')
            ->where("branches.user_id", '=', parentID())
            ->where("branches.active", '=', true)
            ->where("message_logs.type", '=', 'invoice')
            ->where("$this->mainTable.status", '=', 'completed')
            ->where("$this->mainTable.plate_status", '=', 'success')
            ->selectRaw("carprofiles.BayCode as list_id,carprofiles.BayCode as list_name,backout_reasons.reason1,backout_reasons.reason2,backout_reasons.reason3,message_logs.fileUrl, $selectQuery");

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
        if ($filter['download'] ?? false) {
            return collect($query->get())->groupBy("list_id")
                ->mapWithKeys(function ($item) use ($key) {
                    return [$item[0]->list_name => array_map(static function ($el) use ($key) {
                        return [
                            ucfirst($key) . " Name" => $el->list_name,
                            'Branch Name' => $el->branch_name,
                            'Area Name' => "Area# $el->BayCode",
                            'Plate En' => $el->plate_en,
                            'Plate Ar' => $el->plate_ar,
                            'CheckIn Date' => $el->checkInDate,
                            'CheckOutDate' => $el->checkOutDate,
                            'Duration' => str_replace('before', '', \Carbon\Carbon::parse($el->checkInDate)->diffForHumans($el->checkOutDate)),
                            'InvoiceMessageTime' => $el->invoice,
                            'Status' => isset($el->fileUrl) && !empty($el->fileUrl) ? 'invoiced' : 'Backout',
                            'WelcomeMeesageTime' => $el->welcome,
                            'reason 1' => $el->reason1,
                            'reason 2' => $el->reason2,
                            'reason 3' => $el->reason3,
                        ];
                    }, $item->toArray())];
                })->toArray();
        }

        $result = json_decode($query->groupBy("list_id")
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->list_name => $item];
            }), true, 512, JSON_THROW_ON_ERROR);

        $report['charts'] = $this->prepareChart($result, $key);
        $report['branch_backout'] = $this->handleBranchBackout($filter);
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

        $selectQuery = 'branches.name as branch_name,carprofiles.BayCode,plate_en,plate_ar,invoice,welcome,checkInDate,checkOutDate';

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
