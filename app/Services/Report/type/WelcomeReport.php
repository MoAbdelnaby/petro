<?php

namespace App\Services\Report\type;

use App\Services\Report\BaseReport;
use Illuminate\Support\Facades\DB;
use JsonException;

class WelcomeReport extends BaseReport
{
    public $query;
    public string $mainTable = "carprofiles";

    public function getCityQuery($list, $selectQuery = null): void
    {
        foreach (['welcome', 'no_welcome'] as $type) {
            $query[$type] = DB::table($this->mainTable)
                ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
                ->join("regions", "regions.id", '=', "branches.region_id")
                ->join("regions as city", "city.id", '=', "regions.parent_id")
                ->where("$this->mainTable.welcome", $type == 'welcome' ? '<>' : '=', null)
                ->where("$this->mainTable.status", '=', 'completed')
                ->where("$this->mainTable.plate_status", '=', 'success')
                ->where("branches.user_id", '=', parentID())
                ->where("regions.user_id", '=', parentID())
                ->where("branches.active", '=', true)
                ->where("regions.active", '=', true)
                ->whereIn("regions.parent_id", $list);

            if ($type == 'welcome' && !is_null($selectQuery)) {
                $query[$type]->selectRaw("city.id as list_id,city.name as list_name, $selectQuery");
            } else {
                $query[$type]->selectRaw("city.id as list_id,city.name as list_name,COUNT($this->mainTable.id) as $type");
            }
        }
        $this->query = $query;
    }

    public function getRegionQuery($list, $selectQuery = null): void
    {
        foreach (['welcome', 'no_welcome'] as $type) {
            $query[$type] = DB::table($this->mainTable)
                ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
                ->join("regions", "regions.id", '=', "branches.region_id")
                ->where("$this->mainTable.welcome", $type == 'welcome' ? '<>' : '=', null)
                ->where("$this->mainTable.status", '=', 'completed')
                ->where("$this->mainTable.plate_status", '=', 'success')
                ->where("branches.user_id", '=', parentID())
                ->where("regions.user_id", '=', parentID())
                ->where("branches.active", '=', true)
                ->where("regions.active", '=', true)
                ->whereIn("regions.id", $list);

            if ($type == 'welcome' && !is_null($selectQuery)) {
                $query[$type]->selectRaw("regions.id as list_id, regions.name as list_name, $selectQuery");
            } else {
                $query[$type]->selectRaw("regions.id as list_id, regions.name as list_name,COUNT($this->mainTable.id) as $type");
            }
        }

        $this->query = $query;
    }

    public function getBranchQuery($list, $selectQuery = null): void
    {
        foreach (['welcome', 'no_welcome'] as $type) {
            $query[$type] = DB::table($this->mainTable)
                ->whereIn("branch_id", $list)
                ->where("$this->mainTable.status", '=', 'completed')
                ->where("$this->mainTable.plate_status", '=', 'success')
                ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
                ->where("$this->mainTable.welcome", $type == 'welcome' ? '<>' : '=', null)
                ->where("branches.user_id", '=', parentID())
                ->where("branches.active", '=', true);

            if ($type == 'welcome' && !is_null($selectQuery)) {
                $query[$type]->selectRaw("branch_id as list_id,branches.name as list_name, $selectQuery");
            } else {
                $query[$type]->selectRaw("branch_id as list_id,branches.name as list_name,COUNT($this->mainTable.id) as $type");
            }
        }

        $this->query = $query;
    }

    public function getAreaQuery($list, $selectQuery = null): void
    {
        foreach (['welcome', 'no_welcome'] as $type) {
            $query[$type] = DB::table($this->mainTable)
                ->whereIn("$this->mainTable.branch_id", $list)
                ->where("$this->mainTable.status", '=', 'completed')
                ->where("$this->mainTable.plate_status", '=', 'success')
                ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
                ->where("$this->mainTable.welcome", $type == 'welcome' ? '<>' : '=', null)
                ->where("branches.user_id", '=', parentID())
                ->where("branches.active", '=', true);

            if ($type == 'welcome' && !is_null($selectQuery)) {
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
            return collect($this->query['welcome']->get())->groupBy("list_id")
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
                            'Welcome' => $el->welcome,
                        ]);
                    }, $item->toArray())];
                })->toArray();
        }

        foreach (['welcome', 'no_welcome'] as $type) {
            $filter["column"] = "$this->mainTable.checkInDate";
            $query = $this->handleDateFilter($this->query[$type], $filter, true);
            $result[$type] = json_decode($query->groupBy("list_id")
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->list_name => $item];
                }), true, 512, JSON_THROW_ON_ERROR);
        }

        $result = array_merge_recursive_distinct($result['welcome'], $result['no_welcome']);
        $report['charts'] = $this->prepareChart($result, $key);
        $report["branch_check"] = $this->handleReportCompare($filter);
        $report["info"] = [
            "list" => ucfirst($key),
            "unit" => config('app.report.type.welcome.unit'),
            "columns" => config('app.report.type.welcome.data'),
            "display_key" => ["welcome" => __('app.Welcome'), "no_welcome" => __('app.no_welcome')]
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
                $charts["bar"][$i]["welcome"] = round($value["welcome"] ?? 0 / 60);
                $charts["bar"][$i]["no_welcome"] = round($value["no_welcome"] ?? 0 / 60);
                $charts["circle"]["welcome"][$i]['list'] = $filter_key . $key;
                $charts["circle"]["welcome"][$i]["value"] = round($value["welcome"] ?? 0 / 60);
                $charts["circle"]["no_welcome"][$i]['list'] = $filter_key . $key;
                $charts["circle"]["no_welcome"][$i]["value"] = round($value["no_welcome"] ?? 0 / 60);
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
        $data = $this->handleListQuery($filter);
        $list = $data['list'];
        if (!is_array($list)) {
            $list = \Arr::wrap(str_contains($list, ',') ? explode(',', $list) : $list);
        }

        $result = [];
        foreach (['welcome', 'no_welcome'] as $status) {
            $query[$status] = DB::table($this->mainTable)
                ->where("$this->mainTable.status", '=', 'completed')->where("$this->mainTable.plate_status", '=', 'success')
                ->select('branches.id')
                ->join('branches', 'branches.id', '=', "$this->mainTable.branch_id")
                ->where('branches.user_id', parentID())
                ->where('branches.active', true)
                ->whereNull('branches.deleted_at')
                ->distinct();

            if ($data['type'] == 'branch' && ($filter['default'] ?? false) == false) {
                $query[$status] = $query[$status]->whereIn('branches.id', $list);
            }

            $query[$status] = $this->handleDateFilter($query[$status], $filter, true);

            if ($status == 'no_welcome') {
                $result[$status] = $query[$status]->whereNull('welcome')->get()->toArray();
            } else {
                $result[$status] = $query[$status]->whereNotNull('welcome')->get()->toArray();
            }
        }

        $welcomes = array_column($result['welcome'], 'id');
        $no_welcomes = array_column($result['no_welcome'], 'id');
        $no_welcomes = array_values(array_diff($no_welcomes, $welcomes));
        $result['welcome'] = count($welcomes);
        $result['no_welcome'] = count($no_welcomes);

        return $result;
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

        $selectQuery = 'branches.name as branch_name,BayCode,welcome,plate_en,plate_ar,checkInDate,checkOutDate';

        $this->$func_name($list, $selectQuery);

        return $this->getReport($data["type"], $filter);
    }
}
