<?php

namespace App\Http\Controllers\Models;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ConnectionSpeed;
use App\Models\Branch;

class ConnectionSpeedController extends Controller
{

    public function index()
    {
        $logs = ConnectionSpeed::latest()
            ->distinct()
            ->get()
            ->unique('branch_id')
            ->values()
            ->all();
        return view('customer.speeds.index', compact('logs'));
    }

    public function show(Branch $branch)
    {
        $logs = $branch->speedLogs;

        $groupingByDay = [];
        foreach ($logs as $log) {
            if (!isset($groupingByDay[$log->created_at->format('Y-m-d')]))
                $groupingByDay[$log->created_at->format('Y-m-d')] = [
                    'download' => 0,
                    'upload' => 0
                ];

            $groupingByDay[$log->created_at->format('Y-m-d')]['download'] += $log->internet_speed;
            $groupingByDay[$log->created_at->format('Y-m-d')]['upload'] += $log->upload_speed;
        }
        $overall = [];
        foreach ($groupingByDay as $day => $values) {
            $values['download'] /= count($groupingByDay[$day]);
            $values['upload'] /= count($groupingByDay[$day]);

            $overall[] = "{date: ".strtotime($day).", open: ".($values['download']).", close: ".($values['upload'])."}";
        }


//        $today_internet_speed = array_column($branch->speedLogs()->whereDate('created_at', date('Y-m-d'))->get(['internet_speed'])->toArray(), 'internet_speed');
//        $datetimestoday = array_column($branch->speedLogs()->whereDate('created_at', date('Y-m-d'))->get(['created_at'])->toArray(), 'created_at');
//        $today_timesH = [];
//        $today_timesM = [];
//        foreach ($datetimestoday as $datetime) {
//            $today_timesH[] = Carbon::parse($datetime)->format("H");
//            $today_timesM[] = Carbon::parse($datetime)->format("m");
//        }

        return view('customer.speeds.show', compact('logs', 'branch', 'overall', 'groupingByDay'));

    }

    public function store()
    {
        ConnectionSpeed::create([
            'user_id' => auth()->id(),
            'branch_id' => \request('branch_id'),
            'internet_speed' => \request('internet_speed')
        ]);
    }

    public function registerBranch()
    {
        if (auth()->user()->speedtest == 0) {
            return redirect()->back()->with('danger', 'you are not authorized to see this page');
        }
        $branches = Branch::all();

        return view('customer.speeds.registerBranch', compact('branches'));
    }

    public function uploadSpeed(Request $request)
    {
        return response()->json([
            'success' => true
        ]);
    }
}
