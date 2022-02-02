<?php

namespace App\Services\Report;

use App\Models\AreaDurationDay;
use App\Models\AreaStatus;
use App\Models\Branch;
use App\Models\Carprofile;
use App\Models\Region;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * @param string $start
     * @param null $end
     * @param array $lists
     * @return array
     */
    public static function statistics($start = "2022-01-01", $end = null, $lists = null): array
    {
        $users = User::primary()->count();
        $branches = Branch::active()->primary()->count();
        $regions = Region::active()->primary()->count();

        //System Models Staticis
        $cars = Carprofile::where('status', 'completed');
        $invoice = Carprofile::where('status', 'completed');
        $welcome = Carprofile::where('status', 'completed');
        $backout = Carprofile::where('status', 'completed');
        $serving = Carprofile::where('status', 'completed');
        $work = AreaDurationDay::query();
        $empty = AreaDurationDay::query();
        $areas = AreaStatus::query();

        if ($start) {
            $start = Carbon::parse($start)->format('Y-m-d');
            $cars->whereDate('checkInDate', '>=', $start);
            $invoice->whereDate('checkInDate', '>=', $start);
            $welcome->whereDate('checkInDate', '>=', $start);
            $backout->whereDate('checkInDate', '>=', $start);
            $serving->whereDate('checkInDate', '>=', $start);
            $work->whereDate('date', '>=', $start);
            $empty->whereDate('date', '>=', $start);
        }
        if ($end) {
            $end = Carbon::parse($end)->format('Y-m-d');
            $cars->whereDate('checkInDate', '<=', $end);
            $invoice->whereDate('checkInDate', '<=', $end);
            $welcome->whereDate('checkInDate', '<=', $end);
            $backout->whereDate('checkInDate', '<=', $end);
            $serving->whereDate('checkInDate', '<=', $end);
            $work->whereDate('date', '<=', $end);
            $empty->whereDate('date', '<=', $end);
        }

        if (!empty($lists)) {
            if (!is_array($lists)) {
                $lists = str_contains($lists, ',') ? explode(',', (string)$lists) : $lists;
            }
            $lists = \Arr::wrap($lists);
            $cars->whereIn('branch_id', $lists);
            $invoice->whereIn('branch_id', $lists);
            $welcome->whereIn('branch_id', $lists);
            $backout->whereIn('branch_id', $lists);
            $work->whereIn('branch_id', $lists);
            $empty->whereIn('branch_id', $lists);
            $serving->whereIn('branch_id', $lists);
            $areas->whereIn('branch_id', $lists);
        }

        $areas = $areas->count();
        $cars = $cars->count();
        $invoice = $invoice->where('invoice', '<>', null)->count();
        $welcome = $welcome->where('welcome', '<>', null)->count();
        $backout = $backout->where('invoice', '=', null)->count();
        $work = $work->sum('work_by_minute');
        $empty = $empty->sum('empty_by_minute');
        $serving = $serving->select(DB::raw('round(AVG(TIMESTAMPDIFF(MINUTE,checkInDate,checkOutDate)),0) as duration'))->first()['duration'];

        return [
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
            'serving' => $serving,
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
    public static function downloadStatistics($start = "2022-01-01", $end = null, $lists = null)
    {
        if (!is_array($lists)) {
            $lists = str_contains($lists, ',') ? explode(',', (string)$lists) : $lists;
        }
        $branches = \Arr::wrap($lists);

        if (empty($branches)) {
            $branches = Branch::active()->primary()->pluck('id')->toArray();
        }

        foreach ($branches as $branch) {
            //System Models Staticis
            $cars = Carprofile::where('status', 'completed');
            $invoice = Carprofile::where('status', 'completed');
            $welcome = Carprofile::where('status', 'completed');
            $backout = Carprofile::where('status', 'completed');
            $serving = Carprofile::where('status', 'completed');
            $work = AreaDurationDay::query();
            $empty = AreaDurationDay::query();
            $areas = AreaStatus::query();

            if ($start) {
                $start = Carbon::parse($start)->format('Y-m-d');
                $cars->whereDate('checkInDate', '>=', $start);
                $invoice->whereDate('checkInDate', '>=', $start);
                $welcome->whereDate('checkInDate', '>=', $start);
                $backout->whereDate('checkInDate', '>=', $start);
                $serving->whereDate('checkInDate', '>=', $start);
                $work->whereDate('date', '>=', $start);
                $empty->whereDate('date', '>=', $start);
            }
            if ($end) {
                $end = Carbon::parse($end)->format('Y-m-d');
                $cars->whereDate('checkInDate', '<=', $end);
                $invoice->whereDate('checkInDate', '<=', $end);
                $welcome->whereDate('checkInDate', '<=', $end);
                $backout->whereDate('checkInDate', '<=', $end);
                $serving->whereDate('checkInDate', '<=', $end);
                $work->whereDate('date', '<=', $end);
                $empty->whereDate('date', '<=', $end);
            }

            $cars->where('branch_id', $branch);
            $invoice->where('branch_id', $branch);
            $welcome->where('branch_id', $branch);
            $backout->where('branch_id', $branch);
            $work->where('branch_id', $branch);
            $empty->where('branch_id', $branch);
            $serving->where('branch_id', $branch);
            $areas->where('branch_id', $branch);

            $branch_name = Branch::where('id', $branch)->first()['name'];
            $areas_count = $areas->count();
            $cars_count = $cars->count();
            $invoice_count = $invoice->where('invoice', '<>', null)->count();
            $welcome_count = $welcome->where('welcome', '<>', null)->count();
            $backout_count = $backout->where('invoice', '=', null)->count();
            $work_count = round($work->sum('work_by_minute') / 60);
            $empty_count = round($empty->sum('empty_by_minute') / 60);
            $serving_count = $serving->select(DB::raw('round(AVG(TIMESTAMPDIFF(MINUTE,checkInDate,checkOutDate)),0) as duration'))->first()['duration'];

            $result[] = [
                'Branch Name' => $branch_name ?? 0,
                'Start Date' => $start ?? "2022-01-01",
                'End Date' => $end ?? now()->toDateString(),
                'Area Count' => $areas_count ?? 0,
                'Car Count' => $cars_count ?? 0,
                'Invoice' => $invoice_count ?? 0,
                'Backout' => $backout_count ?? 0,
                'Welcome Message' => $welcome_count ?? 0,
                'Work Duration(Hours)' => $work_count ?? 0,
                'Empty Duration(Hours)' => $empty_count ?? 0,
                'Serving Average(Minutes)' => $serving_count ?? 0
            ];
        }

        return $result ?? [];
    }
}
