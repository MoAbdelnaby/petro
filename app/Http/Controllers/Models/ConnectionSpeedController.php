<?php

namespace App\Http\Controllers\Models;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ConnectionSpeed;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;

class ConnectionSpeedController extends Controller
{

    public function index()
    {
        $logs = ConnectionSpeed::with('branch')->select([
                'branch_id',
                DB::raw('AVG(internet_speed) as internet_speed'),
                DB::raw('AVG(upload_speed) as upload_speed'),
            ])
            ->groupBy('branch_id')
            ->get();

        return view('customer.speeds.index', compact('logs'));
    }

    public function show(Branch $branch)
    {
        $logs = $branch->speedLogs()->whereMonth('created_at', date('m'))->get();

        return view('customer.speeds.show', compact('logs', 'branch'));

    }

    public function store()
    {
        ConnectionSpeed::create([
            'user_id' => auth()->id(),
            'branch_id' => \request('branch_id'),
            'internet_speed' => \request('internet_speed'),
            'load_time' => \request('load_time'),
            'upload_speed' => \request('upload_speed'),
            'uploaded_time' => \request('uploaded_time'),
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
