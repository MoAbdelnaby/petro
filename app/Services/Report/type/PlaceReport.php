<?php

namespace App\Services\Report\type;

use App\Models\AreaDurationDay;
use App\Models\Branch;
use App\Models\CarPLatesSetting;
use App\Models\Carprofile;
use App\Models\PlaceMaintenanceSetting;
use App\Models\Region;
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
        if (Carbon::parse($this->filter['start'])->format('d') == Carbon::parse($this->filter['end'])->format('d')) {
            $query = $this->handleDurationCustom($this->filter, $list, false, 'city');
        } else {
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
        }
        $this->query = $query;
    }

    public function getRegionQuery($list)
    {
        if (Carbon::parse($this->filter['start'])->format('d') == Carbon::parse($this->filter['end'])->format('d')) {
            $query = $this->handleDurationCustom($this->filter, $list, false, 'region');
        } else {
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
        }
        $this->query = $query;
    }

    public function getBranchQuery($list)
    {
        if (Carbon::parse($this->filter['start'])->format('d') == Carbon::parse($this->filter['end'])->format('d')) {
            $query = $this->handleDurationCustom($this->filter, $list, false);
        } else {
            $query = DB::table($this->mainTable)
                ->whereIn("branch_id", $list)
                ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
                ->where("branches.user_id", '=', parentID())
                ->where("branches.active", '=', true)
                ->select("branch_id as list_id", "branches.name as list_name",
                    DB::raw("SUM(work_by_minute) as work"),
                    DB::raw("SUM(empty_by_minute) as empty")
                );
        }
        $this->query = $query;
    }

    public function getAreaQuery($list)
    {
        if (Carbon::parse($this->filter['start'])->format('d') == Carbon::parse($this->filter['end'])->format('d')) {
            $query = $this->handleDurationCustom($this->filter, $list, false, 'area');
        } else {
            $query = DB::table($this->mainTable)
                ->whereIn("$this->mainTable.branch_id", $list)
                ->join("branches", "branches.id", '=', "$this->mainTable.branch_id")
                ->where("branches.user_id", '=', parentID())
                ->where("branches.active", '=', true)
                ->select("$this->mainTable.area as list_id", "$this->mainTable.area as list_name",
                    DB::raw("SUM(work_by_minute) as work"),
                    DB::raw("SUM(empty_by_minute) as empty")
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
        if (Carbon::parse($this->filter['start'])->format('d') == Carbon::parse($this->filter['end'])->format('d')) {
            $result = $this->query;
        } else {

            $filter["column"] = "$this->mainTable.date";
            $query = $this->handleDateFilter($this->query, $filter);
            $result = json_decode($query->groupBy("list_id")
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->list_name => $item];
                }), true, 512, JSON_THROW_ON_ERROR);
        }

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
     * @param null $lists
     * @param bool $sum
     * @param string $depth
     * @return array
     */
    public function handleDurationCustom($filter, $lists = null, bool $sum = true, string $depth = 'branch'): array
    {
        $work = [];
        $empty = [];
        if (empty($lists)) {
            $lists = Branch::primary()->active()->pluck('id')->toArray();
        }

        if (!is_array($lists)) {
            $lists = str_contains($lists, ',') ? explode(',', (string)$lists) : $lists;
        }

        $branches_by_region = [];
        if (isset($filter['show_by']) && $filter['region_type']) {
            if (($filter['show_by'] == 'region' && $filter['region_type'] == 'comparison')
                || ($filter['show_by'] == 'city' && $filter['city_type'] == 'region')) {
                $branches_by_region = Branch::whereIn('region_id', $lists)->pluck('region_id', 'id')->toArray();
                $lists = array_keys($branches_by_region);

            } elseif ($filter['show_by'] == 'city' && $filter['city_type'] == 'comparison') {
                $lists = Region::whereIn('parent_id', $lists)->pluck('id')->toArray();
                $branches_by_region = Branch::whereIn('region_id', $lists)->pluck('region_id', 'id')->toArray();
                $lists = array_keys($branches_by_region);
            }
        }

        foreach (\Arr::wrap($lists) as $branch_id) {
            $branch = DB::table('branches')
                ->select('name', 'area_count', 'id')
                ->where('id', $branch_id)
                ->where('active', 1)
                ->where('user_id', parentID())
                ->first();

            if (empty($branch)) {
                continue;
            }

            for ($area = 1; $area <= (int)$branch->area_count ?? 0; $area++) {
                $branch_work = 0;
                $query = Carprofile::where('status', 'completed')
                    ->where('branch_id', $branch->id)
                    ->where('BayCode', $area);

                //Handle date filter by checkInDate
                $filter['column'] = 'checkInDate';
                $this->handleDateFilter($query, $filter, true);

                $query->chunk(500, function ($profiles) use (&$work, &$branch_work, $area, $branch) {
                    foreach ($profiles as $record) {
                        $start = Carbon::parse($record->checkInDate);
                        $end = Carbon::parse($record->checkOutDate);
                        if ($end > $start) {
                            $difference = $end->diffInMinutes($start);
                            $branch_work += $difference;
                            $work["$branch->name,$branch->id"]['area'][$area]['work'][] = $difference;
                        }
                    }
                });

                $user_model_branch = UserModelBranch::with('branch')->where('branch_id', $branch->id)->latest()->first();
                $plate_setting = PlaceMaintenanceSetting::where('user_model_branch_id', $user_model_branch->id)->where('active', 1)->first();
                if (!$plate_setting) {
                    $plate_setting = CarPLatesSetting::where('user_model_branch_id', $user_model_branch->id)->where('active', 1)->first();
                }

                $start_time = Carbon::parse($filter['start']);
                $start_time_setting = Carbon::createFromFormat('Y-m-d H:i',
                    $start_time->format('Y-m-d') . ' ' . $plate_setting->start_time
                );
                $end_time = Carbon::parse($filter['end']);
                $end_time_setting = Carbon::createFromFormat('Y-m-d H:i',
                    $end_time->format('Y-m-d') . ' ' . $plate_setting->end_time
                );
                if ($start_time < $start_time_setting) {
                    $start_time = $start_time_setting;
                }
                if ($end_time > $end_time_setting) {
                    $end_time = $end_time_setting;
                }
                if ($end_time > now()) {
                    $end_time = now();
                }
                if ($end_time < $start_time) {
                    $end_time = Carbon::now();
                }

                $branch_empty = $end_time->diffInMinutes($start_time);
                if ($branch_empty > $branch_work) {
                    $branch_empty -= $branch_work;
                }
                $empty["$branch->name,$branch->id"]['area'][$area]['empty'][] = $branch_empty;
            }
        }

        if ($sum) {
            $work = array_sum(\Arr::flatten($work));
            $empty = array_sum(\Arr::flatten($empty));
            return [$work, $empty];
        }

        $data = array_merge_recursive_distinct($work, $empty);

        return $this->resolveDurationDepth($data, $depth, $branches_by_region);
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

    /**
     * @param $data
     * @param $depth
     * @param array $extra
     * @return array
     */
    public function resolveDurationDepth($data, $depth, array $extra = []): array
    {
        if ($depth == 'branch') {
            $result = [];
            collect($data)->map(function ($area) {
                return collect($area['area'])->map(function ($data) {
                    return [
                        'work' => array_sum($data['work'] ?? []),
                        'empty' => array_sum($data['empty'] ?? [])
                    ];
                });
            })->map(function ($item, $key) use ($data, &$result) {
                $branch_name = explode(',', $key)[0];
                $result[$branch_name] = [
                    'list_id' => explode(',', $key)[1],
                    'list_name' => $branch_name,
                    'work' => array_sum(array_column($item->toArray(), 'work')),
                    'empty' => array_sum(array_column($item->toArray(), 'empty')),
                ];
            })->toArray();

        } elseif ($depth == 'area') {

            $result = collect($data)->map(function ($area) {
                return collect($area['area'])->map(function ($data, $key) {
                    return [
                        'list_id' => $key,
                        'list_name' => $key,
                        'work' => array_sum($data['work'] ?? []),
                        'empty' => array_sum($data['empty'] ?? [])
                    ];
                });
            })->first()->toArray();

        } elseif ($depth == 'region' || $depth == 'city') {
            $result = [];
            $work = [];
            $empty = [];
            collect($data)->map(function ($area) {
                return collect($area['area'])->map(function ($data) {
                    return [
                        'work' => array_sum($data['work'] ?? []),
                        'empty' => array_sum($data['empty'] ?? [])
                    ];
                });
            })->map(function ($item, $key) use ($data, $extra) {
                $branch_id = explode(',', $key)[1];
                $region = Region::find($extra[$branch_id]);
                return [
                    'list_id' => $region->id,
                    'list_name' => $region->name,
                    'work' => array_sum(array_column($item->toArray(), 'work')),
                    'empty' => array_sum(array_column($item->toArray(), 'empty')),
                ];
            })->map(function ($item) use (&$result, &$work, &$empty) {
                $work[$item['list_name']][] = $item['work'] ?? 0;
                $empty[$item['list_name']][] = $item['empty'] ?? 0;

                $result[$item['list_name']] = [
                    'list_id' => $item['list_id'],
                    'list_name' => $item['list_name'],
                    'work' => array_sum($work[$item['list_name']]),
                    'empty' => array_sum($empty[$item['list_name']]),
                ];
            });
        }

        return $result ?? [];
    }
}
