<?php

namespace App\Services;

use App\Models\AreaDuration;
use App\Models\AreaDurationDay;
use App\Models\Carprofile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService
{
    private static $branch_count = 10;
    private static $topPlaceBranch = [];
    private static $topPlateBranch = [];

    /**
     * Get Report Data For comparison between branches depend on models
     *
     * @param string $model
     * @param $bracnh
     * @param $start
     * @param $end
     * @return array
     */
    public static function comparisonReport(string $model = 'all', $bracnh, $start, $end): array
    {
        $charts = [];

        if ($model != 'all' && in_array($model, ['place', 'plate','invoice'])) {
            $fun_name = "{$model}ComparisonReport";
            return self::$fun_name('custom', $bracnh, $start, $end);
        }
        $charts['place'] = self::placeComparisonReport('custom', $bracnh, $start, $end);
        $charts['plate'] = self::plateComparisonReport('custom', $bracnh, $start, $end);

        return $charts;
    }

    /**
     * Get Data Report For One Branch To Show details of areas depend on model type
     *
     * @param string $model
     * @param $bracnh
     * @param $start
     * @param $end
     * @return array
     */
    public static function branchReport(string $model = 'all', $bracnh, $start, $end): array
    {
        $charts = [];
        if ($model != 'all' && in_array($model, ['place', 'plate','invoice'])) {
            $fun_name = "{$model}BranchReport";
            return self::$fun_name($bracnh, $start, $end);
        }
        $charts['place'] = self::placeComparisonReport($bracnh, $start, $end);
        $charts['plate'] = self::plateComparisonReport($bracnh, $start, $end);

        return $charts;
    }

    /**
     * Get Default Report Data For Top 5 Or N Branch To comparison between them depend non modeltype
     *
     * @param string $model
     * @param int|null $count
     * @return array
     */
    public static function defaultcomparison(string $model = 'all', int $count = null): array
    {
        self::$branch_count = $count ?? self::$branch_count;
        self::$topPlaceBranch = DB::table('view_top_branch_place')->pluck('branch_id')->toArray();
        self::$topPlateBranch = DB::table('view_top_branch_plate')->pluck('branch_id')->toArray();

        $charts = [];
        if ($model != 'all' && in_array($model, ['place', 'plate', 'invoice'])) {
            $fun_name = "{$model}ComparisonReport";
            return self::$fun_name();
        }
        $charts['place'] = self::placeComparisonReport();
        $charts['plate'] = self::plateComparisonReport();

        return $charts;
    }

    /**
     *  Prepate Place Model Data For Report and comparison between branch
     *
     * @param string $type
     * @param array $branch
     * @param null $start
     * @param null $end
     * @return array
     */
    public static function placeComparisonReport(string $type = 'default', array $branch = [], $start = null, $end = null): array
    {
        $query = AreaDuration::join('branches', 'branches.id', '=', 'area_durations.branch_id')
            ->where('branches.user_id', '=', parentID())
            ->select('branch_id', 'branches.name as branch_name',
                DB::raw('SUM(work_by_minute) as work'),
                DB::raw('SUM(empty_by_minute) as empty')
            );


        if ($type == 'custom') {
            if ($start != null || $end != null) {
                $query = AreaDurationDay::whereIn('branch_id', $branch);

                if ($start) {
                    $start = ($start > date('Y-m-d')) ? date('Y-m-d') : $start;

                    $query->whereDate('date', '>=', $start);
                }
                if ($end) {
                    $end = ($end > date('Y-m-d')) ? date('Y-m-d') : $end;

                    $query->whereDate('date', '<=', $end);
                }

                $query->join('branches', 'branches.id', '=', 'area_duration_days.branch_id')
                    ->where('branches.user_id', '=', parentID())
                    ->select('branch_id', 'branches.name as branch_name',
                        DB::raw('SUM(work_by_minute) as work'),
                        DB::raw('SUM(empty_by_minute) as empty')
                    );

            } else {
                $query->whereIn('branches.id', $branch);
            }

        } else {

            $query->whereIn('branches.id', array_slice(self::$topPlaceBranch, 0, self::$branch_count));
        }

        $place_data = $query->groupBy('branch_id')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item['branch_name'] => $item];
            })->toArray();

        $charts = self::preparePlaceChart($place_data);
        $charts['dynamic_bar'] = self::dynamicPlaceBar($type, $branch, $start, $end);

        if (isset($charts['dynamic_bar']['data'])) {
            if (count($charts['dynamic_bar']['data']) > 0) {
                return $charts;
            }
        }
        return [];
    }

    /**
     *  Prepate Palte Model Data For Report and comparison between branch
     *
     * @param string $type
     * @param array $branch
     * @param null $start
     * @param null $end
     * @return array
     */
    public static function plateComparisonReport(string $type = 'default', array $branch = [], $start = null, $end = null): array
    {
        $plate_data = Carprofile::where('status', 'completed')
            ->join('branches', 'branches.id', '=', 'carprofiles.branch_id')
            ->where('branches.user_id', '=', parentID())
            ->select(
                'branch_id',
                'branches.name as branch_name',
                DB::raw('COUNT(carprofiles.id) as count')
            );

        if ($type == 'custom') {
            if ($start) {
                $start = ($start > date('Y-m-d')) ? date('Y-m-d') : $start;
                $plate_data = $plate_data->whereDate('checkInDate', '>=', $start);
            }
            if ($end) {
                $end = ($end > date('Y-m-d')) ? date('Y-m-d') : $end;
                $plate_data = $plate_data->whereDate('checkInDate', '<=', $end);
            }
            $plate_data = $plate_data->whereIn('branches.id', $branch);

        } else {
            $plate_data = $plate_data->whereIn('branches.id', array_slice(self::$topPlateBranch, 0, self::$branch_count));
        }

        $plate_data = $plate_data->groupBy('branch_id')->get()
            ->mapWithKeys(function ($item) {
                return [$item['branch_name'] => $item];
            })->toArray();

        $charts = self::preparePlateChart($plate_data);
        $charts['dynamic_bar'] = self::dynamicPlateBar($type, $branch, $start, $end);

        if (isset($charts['dynamic_bar']['data'])) {
            if (count($charts['dynamic_bar']['data']) > 0) {
                return $charts;
            }
        }
        return [];
    }

    /**
     *  Prepate Palte Model Data For Report and comparison between branch
     *
     * @param string $type
     * @param array $branch
     * @param null $start
     * @param null $end
     * @return array
     * @throws \JsonException
     */
    public static function invoiceComparisonReport(string $type = 'default', array $branch = [], $start = null, $end = null): array
    {
        foreach (['invoice', 'no_invoice'] as $status) {
            $result[$status] = DB::table('carprofiles')
                ->join('branches', 'branches.id', '=', 'carprofiles.branch_id')
                ->where('branches.active', true)
                ->whereNull('branches.deleted_at');

            if ($type == 'custom') {
                if ($start) {
                    $start = ($start > date('Y-m-d')) ? date('Y-m-d') : $start;
                    $result[$status]->whereDate('created_at', '>=', $start);
                }
                if ($end) {
                    $end = ($end > date('Y-m-d')) ? date('Y-m-d') : $end;
                    $result[$status]->whereDate('created_at', '<=', $end);
                }
                $result[$status]->whereIn('branches.id', $branch);
            } else {
                $result[$status]->whereIn('branches.id', array_slice(self::$topPlaceBranch, 0, self::$branch_count));
            }

            if ($status === 'no_invoice') {
                $result[$status]->whereNull('invoice')
                    ->select('branches.name as branch', DB::raw('COUNT(carprofiles.id) as no_invoice'))
                    ->groupBy('branch');
            } else {
                $result[$status]->whereNotNull('invoice')
                    ->select('branches.name as branch', DB::raw('COUNT(carprofiles.id) as invoice'));
            }

            $result[$status] = json_decode($result[$status]->groupBy('branch')
                ->get(),true, 512, JSON_THROW_ON_ERROR);
        }

        return self::prepareInvoiceChart($result);
    }

    /**
     *  Prepate Place Model Data For Report and Show Details about area in one branch
     *
     * @param $branch
     * @param null $start
     * @param null $end
     * @return array
     */
    public static function placeBranchReport($branch, $start = null, $end = null): array
    {
        $area_duration = AreaDuration::where('branch_id', $branch);

        if ($start != null || $end != null) {

            $area_duration = AreaDurationDay::where('branch_id', $branch);

            if ($start) {
                $start = ($start > date('Y-m-d')) ? date('Y-m-d') : $start;
                $area_duration = $area_duration->whereDate('date', '>=', $start);
            }
            if ($end) {
                $end = ($end > date('Y-m-d')) ? date('Y-m-d') : $end;
                $area_duration = $area_duration->whereDate('date', '<=', $end);
            }
        }

        $area_duration = $area_duration->select('area',
            DB::raw('SUM(work_by_minute) as work'),
            DB::raw('SUM(empty_by_minute) as empty')
        )->groupBy('area')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item['area'] => $item];
            })->toArray();

        $charts = self::preparePlaceChart($area_duration, 'area');

        return $charts;
    }

    /**
     * Prepate Plate Model Data For Report and Show Details about area in one branch
     *
     * @param $branch
     * @param null $start
     * @param null $end
     * @return array
     */
    public static function plateBranchReport($branch, $start = null, $end = null): array
    {
        $count_query = Carprofile::select(DB::raw('count(id) as count , BayCode'))
            ->where('status', 'completed')
            ->where('branch_id', $branch);

        if ($start) {
            $start = ($start > date('Y-m-d')) ? date('Y-m-d') : $start;
            $count_query = $count_query->whereDate('checkInDate', '>=', $start);
        }

        if ($end) {
            $end = ($end > date('Y-m-d')) ? date('Y-m-d') : $end;
            $count_query = $count_query->whereDate('checkInDate', '<=', $end);
        }

        $plate_data = $count_query->groupBy('BayCode')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item['BayCode'] => $item];
            })->toArray();

        return self::preparePlateChart($plate_data, 'area');
    }

    /**
     * Get Data Of Dynamic BarChart For Place Per Month For N Branches in Scope Of Date
     *
     * @param string $type
     * @param array $branch
     * @param null $start
     * @param null $end
     * @return array
     */
    public static function dynamicPlaceBar(string $type = 'default', array $branch = [], $start = null, $end = null): array
    {
        $query = DB::table('area_duration_days')
            ->join('branches', 'branches.id', '=', 'area_duration_days.branch_id')
            ->where('branches.user_id', '=', parentID())
            ->select(['branch_id', 'branches.name as branch', 'work_by_minute', 'empty_by_minute', 'date', 'branch_id']);

        if ($type == 'custom') {
            if ($start) {
                $start = ($start > date('Y-m-d')) ? date('Y-m-d') : $start;
                $query->whereDate('date', '>=', $start);
            }
            if ($end) {
                $end = ($end > date('Y-m-d')) ? date('Y-m-d') : $end;
                $query->whereDate('date', '<=', $end);
            }
            $query->whereIn('branches.id', $branch);
            $branchesFilter = $branch;
        } else {
            $branchesFilter = array_slice(self::$topPlaceBranch, 0, self::$branch_count);
            $query->whereIn('branches.id', $branchesFilter);
        }
        $newData = [];
        $work = array_fill_keys($branchesFilter, 0);
        $empty = array_fill_keys($branchesFilter, 0);
        $standrDynamicBar = [];

        $dynamicBar = $query->get()
            ->groupBy(function ($items) {
                return Carbon::parse($items->date)->format('M Y');
            })->map(function ($item) use (&$work, &$empty, &$standrDynamicBar) {
                $item = (array_values($item->groupBy('branch_id')
                    ->map(function ($branch) use (&$work, &$empty, &$standrDynamicBar) {
                        $work[$branch->first()->branch_id] += array_sum(array_column($branch->toArray(), 'work_by_minute'));
                        $empty[$branch->first()->branch_id] += array_sum(array_column($branch->toArray(), 'empty_by_minute'));

                        $branchArray = [$branch->first()->branch_id => $branch->first()->branch];

                        $standrDynamicBar = array_unique($branchArray + $standrDynamicBar);

                        $newData = [
                            'work' => round($work[$branch->first()->branch_id] / 60, 2),
                            'empty' => round($work[$branch->first()->branch_id] / 60, 2),
                            'branch' => $branch->first()->branch,
                            'branch_id' => $branch->first()->branch_id
                        ];
                        return $newData;

                    })->toArray()));
                return $item;
            });

        $newData = $dynamicBar->transform(function ($item) use ($standrDynamicBar) {
            if (count($item) < count($standrDynamicBar)) {

                $dif = array_diff(array_keys($standrDynamicBar), array_column($item, 'branch_id'));

                sort($dif);

                $item = array_merge($item, array_map(function ($difItem) use ($standrDynamicBar) {
                    return [
                        'work_by_minute' => 0,
                        'empty_by_minute' => 0,
                        'branch' => $standrDynamicBar[$difItem],
                        'branch_id' => $difItem,
                    ];
                }, $dif));
            }
            return $item;
        })->toArray();

        $final['data'] = $newData;
        $final['start_at'] = \Carbon\Carbon::parse(array_key_first($final['data']))->format('m-d-Y');
        $final['end_at'] = \Carbon\Carbon::parse(array_key_last($final['data']))->format('m-d-Y');

        return $final;
    }

    /**
     * Get Data Of Dynamic Bar Chart for Plate Per Month For N Branches in Scope Of Date
     *
     * @param string $type
     * @param array $branch
     * @param null $start
     * @param null $end
     * @return array
     */
    public static function dynamicPlateBar(string $type = 'default', array $branch = [], $start = null, $end = null): array
    {
        $plate_data = Db::table('carprofiles')
            ->select(['branches.name as branch', 'carprofiles.id', 'carprofiles.branch_id', 'carprofiles.checkInDate'])
            ->where('carprofiles.status', 'completed')
            ->join('branches', 'branches.id', '=', 'carprofiles.branch_id')
            ->where('branches.user_id', '=', parentID());

        if ($type == 'custom') {

            if ($start) {
                $start = ($start > date('Y-m-d')) ? date('Y-m-d') : $start;
                $plate_data = $plate_data->whereDate('checkInDate', '>=', $start);
            }
            if ($end) {
                $end = ($end > date('Y-m-d')) ? date('Y-m-d') : $end;
                $plate_data = $plate_data->whereDate('checkInDate', '<=', $end);
            }

            $plate_data = $plate_data->whereIn('branches.id', $branch);
            $branchesFilter = $branch;

        } else {

            $branchesFilter = array_slice(self::$topPlateBranch, 0, self::$branch_count);
            $plate_data = $plate_data->whereIn('branches.id', $branchesFilter);
        }

        $count = array_fill_keys($branchesFilter, 0);
        $standrDynamicBar = [];

        $dynamicBar = $plate_data->get()
            ->groupBy(function ($items) {
                return Carbon::parse($items->checkInDate)->format('M Y');
            })->map(function ($item) use (&$count, &$standrDynamicBar) {
                return array_values($item->groupBy('branch_id')
                    ->map(function ($branch) use (&$count, &$standrDynamicBar) {

                        $count[$branch->first()->branch_id] += $branch->count();

                        $branchArray = [$branch->first()->branch_id => $branch->first()->branch];

                        $standrDynamicBar = array_unique($branchArray + $standrDynamicBar);

                        $newData = [
                            'count' => $count[$branch->first()->branch_id],
                            'branch' => $branch->first()->branch,
                            'branch_id' => $branch->first()->branch_id
                        ];

                        return $newData;

                    })->toArray());
            });

        $newData = $dynamicBar->transform(function ($item) use ($standrDynamicBar) {
            if (count($item) < count($standrDynamicBar)) {

                $dif = array_diff(array_keys($standrDynamicBar), array_column($item, 'branch_id'));

                sort($dif);

                $item = array_merge($item, array_map(function ($difItem) use ($standrDynamicBar) {
                    return [
                        'count' => 0,
                        'branch' => $standrDynamicBar[$difItem],
                        'branch_id' => $difItem,
                    ];
                }, $dif));
            }

            return $item;
        })->toArray();

        $final['data'] = $newData;
        $final['start_at'] = \Carbon\Carbon::parse(array_key_first($final['data']))->format('m-d-Y');
        $final['end_at'] = \Carbon\Carbon::parse(array_key_last($final['data']))->format('m-d-Y');

        return $final;
    }

    /**
     * Prepare Format of Place Data Chart
     *
     * @param $place_data
     * @param string $key_name
     * @return array
     */
    public static function preparePlaceChart($place_data, string $key_name = 'branch'): array
    {
        $charts = [];
        $filter_key = ($key_name == 'area') ? 'Area#' : '';
        if (count(array_filter(array_values($place_data))) > 0) {
            $i = 0;
            foreach ($place_data as $key => $value) {
                $charts['bar'][$i][$key_name] = $filter_key . ' ' . $key;
                $charts['bar'][$i]['work'] = round($value['work'] / 60, 2);
                $charts['bar'][$i]['empty'] = round($value['empty'] / 60, 2);
                $i++;
            }

            $k = 0;
            foreach ($place_data as $key => $value) {
                $charts['circle']['work'][$k][$key_name] = $filter_key . ' ' . $key;
                $charts['circle']['work'][$k]['value'] = round($value['work'] / 60, 2);
                $k++;
            }

            $j = 0;
            foreach ($place_data as $key => $value) {
                $charts['circle']['empty'][$j][$key_name] = $filter_key . ' ' . $key;
                $charts['circle']['empty'][$j]['value'] = round($value['empty'] / 60, 2);
                $j++;
            }
        }

        return $charts;
    }

    /**
     * Prepare Format of Plate Data Chart
     *
     * @param $plate_data
     * @param string $key_name
     * @return array
     */
    public static function preparePlateChart($plate_data, string $key_name = 'branch'): array
    {
        $charts = [];
        $x = 0;
        $filter_key = ($key_name == 'area') ? 'Area#' : '';
        if (count(array_filter(array_values($plate_data))) > 0) {
            foreach ($plate_data as $key => $value) {
                $charts['data'][$x][$key_name] = $filter_key . ' ' . $key;
                $charts['data'][$x]['count'] = $value['count'];
                $x++;
            }
        }
        return $charts;
    }

    /**
     * Prepare Format of Place Data Chart
     *
     * @param $data
     * @return array
     */
    public static function prepareInvoiceChart($data): array
    {
        $result = array_merge_recursive_distinct($data['invoice'], $data['no_invoice']);

        $columns = ['invoice', 'no_invoice'];
        return collect($result)->map(function ($item) use ($columns) {
            foreach ($columns as $column) {
                if (!isset($item[$column])) {
                    $item[$column] = 0;
                }
            }
            return $item;
        })->toArray();
    }
}
