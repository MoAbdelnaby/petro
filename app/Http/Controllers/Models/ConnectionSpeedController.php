<?php

namespace App\Http\Controllers\Models;

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

        return view('customer.speeds.show', compact('logs', 'branch'));

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
        $branches = Branch::all();

        return view('customer.speeds.registerBranch', compact( 'branches'));
    }
}
