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
            $userscount = User::where('parent_id', parentID())->count();
            $branches = Branch::where('active', true)->where('user_id', parentID())->pluck('name', 'id')->toArray();
            $branches_report = Branch::where('active', true)->where('user_id', parentID())->whereIn('id', DB::table('view_top_branch_place')->pluck('branch_id')->toArray())->take(6)->pluck('name');

            if ($type == 'invoice') {
                $branches_check = $this->handleReportCompare(['invoice', 'no_invoice']);
            } elseif ($type == 'welcome') {
                $branches_check = $this->handleReportCompare(['welcome', 'no_welcome']);
            }

            return view("customer.reports.{$type}", [
                'regioncount' => $regioncount,
                'branchcount' => count($branches),
                'branches_check' => $branches_check??[],
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

            if ($model_type == 'invoice') {
                $filter_type = 'comparison';
                $filter_key = 'branch';
                $branch = \Arr::wrap($branch);
                $branches_check = $this->handleReportCompare(['invoice', 'no_invoice']);
            } elseif ($model_type == 'welcome') {
                $filter_type = 'comparison';
                $filter_key = 'branch';
                $branch = \Arr::wrap($branch);
                $branches_check = $this->handleReportCompare(['welcome', 'no_welcome']);
            }

            $func_name = $filter_type . 'Report';
            $charts = ReportService::$func_name($model_type, $branch, $request->start_date, $request->end_date);
            $config = ConfigService::get($model_type);

            //Count in statistics
            $regioncount = Region::where('active', true)->where('user_id', parentID())->count();
            $userscount = User::where('parent_id', parentID())->count();
            $branches = Branch::where('active', true)->where('user_id', parentID())->pluck('name', 'id')->toArray();
            $branches_report = Branch::where('active', true)->where('user_id', parentID())->whereIn('id', \Arr::wrap($branch))->take(6)->pluck('name');

            return view("customer.reports.{$model_type}", [
                'regioncount' => $regioncount,
                'branchcount' => count($branches),
                'userscount' => $userscount,
                'branches' => $branches,
                'branches_check' => $branches_check ?? [],
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

    public function handleReportCompare($items = []): array
    {
        $branches_check = [];

        foreach ($items as $status) {
            $branches_check[$status] = DB::table('carprofiles')
                ->select('branches.id')
                ->join('branches', 'branches.id', '=', 'carprofiles.branch_id')
                ->where('branches.user_id', parentID())
                ->where('branches.active', true)
                ->whereNull('branches.deleted_at')
                ->distinct();

            if ($status === 'no_invoice') {
                $branches_check[$status] = $branches_check[$status]->whereNull('invoice')->get()->toArray();
            } elseif ($status == 'invoice') {
                $branches_check[$status] = $branches_check[$status]->whereNotNull('invoice')->get()->toArray();
            } elseif ($status == 'no_welcome') {
                $branches_check[$status] = $branches_check[$status]->whereNotNull('welcome')->get()->toArray();
            } elseif ($status == 'welcome') {
                $branches_check[$status] = $branches_check[$status]->whereNotNull('welcome')->get()->toArray();
            }
        }
        if (in_array('invoice', $items) || in_array('no_invoice', $items)) {
            $invoices = array_column($branches_check['invoice'], 'id');
            $no_invoices = array_column($branches_check['no_invoice'], 'id');
            $no_invoices = array_values(array_diff($no_invoices, $invoices));
            $branches_check['invoice'] = count($invoices);
            $branches_check['no_invoice'] = count($no_invoices);

        } elseif (in_array('welcome', $items) || in_array('no_welcome', $items)) {

            $welcomes = array_column($branches_check['welcome'], 'id');
            $no_welcomes = array_column($branches_check['no_welcome'], 'id');
            $no_welcomes = array_values(array_diff($no_welcomes, $welcomes));
            $branches_check['welcome'] = count($welcomes);
            $branches_check['no_welcome'] = count($no_welcomes);
        }

        return $branches_check;
    }
}
