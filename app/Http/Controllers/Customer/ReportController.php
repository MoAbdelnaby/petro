<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Region;
use App\Services\ConfigService;
use App\Services\ReportService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function index($type)
    {
        try {
            // Get Top {5} Branch Report By Model Type
            $charts = ReportService::defaultcomparison($type ?? 'place');
            $config = ConfigService::get($type);
            $regioncount = Region::where('active', true)->where('user_id', parentID())->count();
            $branchcount = Branch::where('active', true)->where('user_id', parentID())->count();
            $userscount = User::where('parent_id', parentID())->count();
            $branches = Branch::where('active', true)->where('user_id', parentID())->pluck('name', 'id')->toArray();
            $branches_report = Branch::where('active', true)->where('user_id', parentID())->whereIn('id',DB::table('view_top_branch_place')->pluck('branch_id')
                ->toArray())->take(6)->pluck('name');

            return view("customer.reports.{$type}", [
                'regioncount' => $regioncount,
                'branchcount' => $branchcount,
                'userscount' => $userscount,
                'branches' => $branches,
                'branches_report' => $branches_report,
                'modelscount' => 2,
                'charts' => $charts,
                'config' => $config,
                'filter_type' => 'comparison',
                'filter_key' => 'branch',
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'UnKnowm Error');
        }
    }

    public function filter($model_type, Request $request)
    {
        try {
            $valdaitor = Validator::make($request->all(), [
                'filter_type' => 'required|string|in:comparison,branch',
                'branch_comparison' => 'required_if:filter_type,comparison|array',
                'branch_data' => 'required_if:filter_type,branch',
                'start_date' => 'nullable|date|before_or_equal:end_date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
            ]);

            if ($valdaitor->errors()->count()) {
                return redirect()->back()->withErrors($valdaitor->errors())->withInput();
            }

            $filter_type = $request->filter_type;
            $filter_key = ($filter_type != 'comparison') ? 'area' : 'branch';
            $branch = ($filter_type != 'comparison') ? $request->branch_data : $request->branch_comparison;

            if($model_type == 'invoice'){
                $filter_type = 'comparison';
                $filter_key = 'branch';
                $branch = \Arr::wrap($branch);
            }

            $func_name = $filter_type . 'Report';

            //Prepare Chart Data And Conig By Type
            $charts = ReportService::$func_name($model_type, $branch, $request->start_date, $request->end_date);
            $config = ConfigService::get($model_type);

            //Count in statistics
            $regioncount = Region::where('active', true)->where('user_id', parentID())->count();
            $branchcount = Branch::where('active', true)->where('user_id', parentID())->count();
            $userscount = User::where('parent_id', parentID())->count();
            $branches = Branch::where('active', true)->where('user_id', parentID())->pluck('name', 'id')->toArray();
            $branches_report = Branch::where('active', true)->where('user_id', parentID())
                ->whereIn('id',\Arr::wrap($branch))->take(6)->pluck('name');

            return view("customer.reports.{$model_type}", [
                'regioncount' => $regioncount,
                'branchcount' => $branchcount,
                'userscount' => $userscount,
                'branches' => $branches,
                'branches_report' => $branches_report,
                'modelscount' => 2,
                'charts' => $charts,
                'config' => $config,
                'filter_type' => $filter_type,
                'filter_key' => $filter_key,
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'UnKnowm Error');
        }
    }


    public function download($model_type, Request $request)
    {

        $request->validate([
            'filter_type' => 'sometimes|nullable|string|in:comparison,branch',
            'branch_comparison' => 'required_if:filter_type,comparison|min:2|max:5',
            'branch_data' => 'required_if:filter_type,branch|max:1',
            'start_date' => 'sometimes|nullable|date',
            'end_date' => 'sometimes|nullable|date',
        ]);

        if ($request->has('filter_type') && $request->has('branch_data') && $request->has('end_date') && $request->has('start_date')) {

            $filter_type = $request->filter_type;
            $filter_key = ($filter_type != 'comparison') ? 'area' : 'branch';
            $branch = ($filter_type != 'comparison') ? $request->branch_data : $request->branch_comparison;
            $func_name = $filter_type . 'Report';

            $charts = ReportService::$func_name($model_type, $branch, $request->start_date, $request->end_date);
            $config = ConfigService::get($model_type);

        } else {

            $charts = ReportService::defaultcomparison($model_type);
            $config = ConfigService::get($model_type);
            $filter_type = 'comparison';
            $filter_key = 'branch';
        }

        //Count in statistics
        $regioncount = Region::where('active', true)->where('user_id', parentID())->count();
        $branchcount = Branch::where('active', true)->where('user_id', parentID())->count();
        $userscount = User::where('parent_id', parentID())->count();
        $branches = Branch::where('active', true)->where('user_id', parentID())->pluck('name', 'id')->toArray();

        return view("customer.reports.download.{$model_type}", [
            'regioncount' => $regioncount,
            'branchcount' => $branchcount,
            'userscount' => $userscount,
            'branches' => $branches,
            'modelscount' => 2,
            'charts' => $charts,
            'config' => $config,
            'filter_type' => $filter_type,
            'filter_key' => $filter_key,
        ]);

        $pdf->setOption('enable-javascript', true);
        $pdf->setOption('enable-smart-shrinking', true);
        $pdf->setOption('no-stop-slow-scripts', true);

        return $pdf->download("Report_{$filter_type}_{$filter_key}_" . rand(20, 40) . ".pdf");

    }
}
