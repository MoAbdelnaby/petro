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
     * @param $start
     * @param $end
     * @return array
     */
    public static function statistics($start = null, $end = null)
    {
        $branches = Branch::active()->primary()->count();
        $regions = Region::active()->primary()->count();
        $users = User::primary()->count();
        $cars = Carprofile::whereDate('checkInDate', '2022-01-01')->count();
        $areas = AreaStatus::count();
        $invoice = Carprofile::whereDate('checkInDate', '2022-01-01')->where('invoice', '<>', null)->count();
        $welcome = Carprofile::whereDate('checkInDate', '2022-01-01')->where('welcome', '<>', null)->count();
        $backout = Carprofile::whereDate('checkInDate', '2022-01-01')->where('invoice', '=', null)->count();
        $work = AreaDurationDay::whereDate('date', '2022-01-01')->sum('work_by_minute');
        $empty = AreaDurationDay::whereDate('date', '2022-01-01')->sum('empty_by_minute');
        $serving = Carprofile::select(DB::raw('round(AVG(TIMESTAMPDIFF(MINUTE,checkInDate,checkOutDate)),0) as duration'))->first()['duration'];

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
