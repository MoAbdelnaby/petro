<?php

namespace App\Services\Report;

use App\Models\AreaStatus;
use App\Models\Branch;
use App\Models\Carprofile;
use App\Models\Region;
use App\Services\Report\type\PlaceReport;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * @param string $start
     * @param null $end
     * @param null $lists
     * @return array
     */
    public static function statistics($start = null, $end = null, $lists = null): array
    {
        $users = User::primary()->count();
        $branches = Branch::primary()->count();
        $active_branches = Branch::active()->primary()->count();
        $regions = Region::active()->primary()->count();
        $filter = [
            'start' => $start,
            'default' => true,
            'column' => 'checkInDate',
            'end' => $end
        ];

        //System Models Statics
        $cars = Carprofile::where('status', 'completed')->where('plate_status', 'success');
        $invoice = Carprofile::where('status', 'completed')->where('plate_status', 'success');
        $welcome = Carprofile::where('status', 'completed')->where('plate_status', 'success');
        $backout = Carprofile::where('status', 'completed')->where('plate_status', 'success');
        $serving = Carprofile::where('status', 'completed')->where('plate_status', 'success');
        $areas = AreaStatus::query();

        //Handle filter date [start-end]
        self::handleDateFilter($cars, $filter, true);
        self::handleDateFilter($invoice, $filter, true);
        self::handleDateFilter($welcome, $filter, true);
        self::handleDateFilter($backout, $filter, true);
        self::handleDateFilter($serving, $filter, true);

        if (!empty($lists)) {
            if (!is_array($lists)) {
                $lists = str_contains($lists, ',') ? explode(',', (string)$lists) : $lists;
            }
            $lists = \Arr::wrap($lists);
            $cars->whereIn('branch_id', $lists);
            $invoice->whereIn('branch_id', $lists);
            $welcome->whereIn('branch_id', $lists);
            $backout->whereIn('branch_id', $lists);
            $serving->whereIn('branch_id', $lists);
            $areas->whereIn('branch_id', $lists);
        }

        $areas = $areas->count();
        $cars = $cars->count();
        $invoice = $invoice->where('invoice', '<>', null)->count();
        $welcome = $welcome->where('welcome', '<>', null)->count();
        $backout = $backout->where('invoice', '=', null)->count();
        $serving = $serving->select(DB::raw('round(AVG(TIMESTAMPDIFF(MINUTE,checkInDate,checkOutDate)),0) as duration'))->first()['duration'];

        //Handle work-empty duration statistics based on date
        //1. if statistics in one day calculated based on place_maintenances table
        //2. if statistics in more one day calculated based on area_duration_day table
        $placeReport = new PlaceReport();
//        if (Carbon::parse($filter['start'])->format('d') == Carbon::parse($filter['end'])->format('d')) {
//            [$work, $empty] = $placeReport->handleDurationCustom($filter, $lists);
//        } else {
        $work = $placeReport->handleDurationDay($filter, 'work', $lists);
        $empty = $placeReport->handleDurationDay($filter, 'empty', $lists);
//        }

        return [
            'active_branches' => $active_branches,
            'branches' => $branches,
            'users' => $users,
            'regions' => $regions,
            'cars' => $cars,
            'areas' => $areas,
            'invoice' => $invoice,
            'welcome' => $welcome,
            'backout' => $backout,
            'work' => $work,
            'empty' => $empty,
            'serving' => $serving ?? 0,
        ];
    }

    /**
     * @param $type
     * @param $filter
     * @return array
     * @throws Exception
     */
    public static function handle($type, $filter): array
    {
        try {
            $reportObject = BaseReportFactory::handle($type);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $reportObject->prepare($filter);
    }

    /**
     * @param string $start
     * @param null $end
     * @param null $lists
     * @return array
     */
    public static function downloadStatistics($start = null, $end = null, $lists = null): array
    {
        if (!is_array($lists)) {
            $lists = str_contains($lists, ',') ? explode(',', (string)$lists) : $lists;
        }
        $branches = \Arr::wrap($lists);

        if (empty($branches)) {
            $branches = Branch::active()->primary()->get();
        }

        foreach ($branches as $branch) {
            $filter = [
                'start' => $start,
                'default' => true,
                'column' => 'checkInDate',
                'end' => $end
            ];

            //System Models Statics
            $cars = Carprofile::where('status', 'completed')->where('plate_status', 'success')->where('branch_id', $branch->id);
            $invoice = Carprofile::where('status', 'completed')->where('plate_status', 'success')->where('branch_id', $branch->id);
            $welcome = Carprofile::where('status', 'completed')->where('plate_status', 'success')->where('branch_id', $branch->id);
            $backout = Carprofile::where('status', 'completed')->where('plate_status', 'success')->where('branch_id', $branch->id);
            $serving = Carprofile::where('status', 'completed')->where('plate_status', 'success')->where('branch_id', $branch->id);
            $areas = AreaStatus::query();

            //Handle filter date [start-end]
            self::handleDateFilter($cars, $filter, true);
            self::handleDateFilter($invoice, $filter, true);
            self::handleDateFilter($welcome, $filter, true);
            self::handleDateFilter($backout, $filter, true);
            self::handleDateFilter($serving, $filter, true);

            $areas = $areas->count();
            $cars = $cars->count();
            $invoice = $invoice->where('invoice', '<>', null)->count();
            $welcome = $welcome->where('welcome', '<>', null)->count();
            $backout = $backout->where('invoice', '=', null)->count();
            $serving = $serving->select(DB::raw('round(AVG(TIMESTAMPDIFF(MINUTE,checkInDate,checkOutDate)),0) as duration'))->first()['duration'];


            //Handle work-empty duration statistics based on date
            //1. if statistics in one day calculated based on place_maintenances table
            //2. if statistics in more one day calculated based on area_duration_day table
            $placeReport = new PlaceReport();
//            if (Carbon::parse($filter['start'])->format('d') == Carbon::parse($filter['end'])->format('d')) {
//                [$work, $empty] = $placeReport->handleDurationCustom($filter, $lists);
//            } else {
            $work = $placeReport->handleDurationDay($filter, 'work', $lists);
            $empty = $placeReport->handleDurationDay($filter, 'empty', $lists);
//            }

            $result[] = [
                'Branch Name' => $branch->name ?? 0,
                'Start Date' => $start ?? now()->startOfYear()->toDateString(),
                'End Date' => $end ?? now()->toDateString(),
                'Area Count' => $areas ?? 0,
                'Car Count' => $cars ?? 0,
                'Invoice' => $invoice ?? 0,
                'Backout' => $backout ?? 0,
                'Welcome Message' => $welcome ?? 0,
                'Work Duration(Hours)' => $work ? round($work / 60) : 0,
                'Empty Duration(Hours)' => $empty ? round($empty / 60) : 0,
                'Serving Average(Minutes)' => $serving ?? 0
            ];
        }

        return $result ?? [];
    }

    /**
     * Helper Function Use to handle time range
     *
     * @param $query
     * @param $filter
     * @param bool $timeStamp
     * @return mixed
     */
    public static function handleDateFilter($query, $filter, bool $timeStamp = false)
    {
        $filter['start'] = empty($filter['start']) ? now()->startOfYear()->toDateString() : $filter['start'];

        if ($filter['start'] ?? false) {
            $start = (Carbon::parse($filter['start']) > now()) ? now() : Carbon::parse($filter['start']);
            if ($timeStamp) {
                $query->where($filter['column'], '>=', $start->format('Y-m-d H:i:s'));
            } else {
                $query->whereDate($filter['column'], '>=', $start->format('Y-m-d'));
            }
        }

        if ($filter['end'] ?? false) {
            $end = Carbon::parse($filter['end']) > now() ? now() : Carbon::parse($filter['end']);
            if ($timeStamp) {
                $query->where($filter['column'], '<=', $end->format('Y-m-d H:i:s'));
            } else {
                $query->whereDate($filter['column'], '<=', $end->format('Y-m-d'));
            }
        }

        return $query;
    }
}
