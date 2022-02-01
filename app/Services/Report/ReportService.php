<?php

namespace App\Services\Report;

use App\Models\AreaDurationDay;
use App\Models\AreaStatus;
use App\Models\Branch;
use App\Models\Carprofile;
use App\Models\Region;
use App\User;
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
        $areas = AreaStatus::count();
        $users = User::primary()->count();
        $branches = Branch::active()->primary()->count();
        $regions = Region::active()->primary()->count();

        //Systm Models Staticis
        $cars = Carprofile::where('status', 'completed');
        $invoice = Carprofile::where('status', 'completed');
        $welcome = Carprofile::where('status', 'completed');
        $backout = Carprofile::where('status', 'completed');
        $serving = Carprofile::where('status', 'completed');
        $work = AreaDurationDay::query();
        $empty = AreaDurationDay::query();

        if ($start) {
            $cars->whereDate('checkInDate', '>=', $start);
            $invoice->whereDate('checkInDate', '>=', $start);
            $welcome->whereDate('checkInDate', '>=', $start);
            $backout->whereDate('checkInDate', '>=', $start);
            $work->whereDate('checkInDate', '>=', $start);
            $empty->whereDate('checkInDate', '>=', $start);
            $serving->whereDate('checkInDate', '>=', $start);
        }
        if ($end) {
            $cars->whereDate('checkInDate', '<=', $end);
            $invoice->whereDate('checkInDate', '<=', $end);
            $welcome->whereDate('checkInDate', '<=', $end);
            $backout->whereDate('checkInDate', '<=', $end);
            $work->whereDate('checkInDate', '<=', $end);
            $empty->whereDate('checkInDate', '<=', $end);
            $serving->whereDate('checkInDate', '<=', $end);
        }

        if ($lists) {
            if (!is_array($lists)) {
                $lists = str_contains($lists, ',') ? explode(',', (string)$lists) : $lists;
            }
            $lists = \Arr::wrap($lists);

//            $cars->whereIn('brannch_id', $lists);
//            $invoice->whereIn('brannch_id', $lists);
//            $welcome->whereIn('brannch_id', $lists);
//            $backout->whereIn('brannch_id', $lists);
//            $work->whereIn('brannch_id', $lists);
//            $empty->whereIn('brannch_id', $lists);
//            $serving->whereIn('brannch_id', $lists);
        }

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
}
