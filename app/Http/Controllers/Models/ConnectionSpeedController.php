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
        $internet_speed = array_column($branch->speedLogs()->get(['internet_speed'])->toArray(),'internet_speed');
//        dd($internet_speed);
        $datetimes = array_column($branch->speedLogs()->get(['created_at'])->toArray(),'created_at');
        $dates = [];
        $times = [];
        foreach ($datetimes as $datetime) {
            $dates[] = Carbon::parse($datetime)->format('Y-m-d');
            $times[] = Carbon::parse($datetime)->format("H");
        }

        $today_internet_speed = array_column($branch->speedLogs()->whereDate('created_at' , date('Y-m-d'))->get(['internet_speed'])->toArray(),'internet_speed');
        $datetimes = array_column($branch->speedLogs()->whereDate('created_at' , date('Y-m-d'))->get(['created_at'])->toArray(),'created_at');
        $today_times = [];
        foreach ($datetimes as $datetime) {
            $today_times[] = Carbon::parse($datetime)->format("H");
        }

        return view('customer.speeds.show', compact('logs', 'branch','internet_speed', 'dates', 'times','today_times','today_internet_speed'));

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

        return view('customer.speeds.registerBranch', compact( 'branches'));
    }
}
