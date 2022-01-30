<?php

namespace App\Http\Controllers\Customer;

use App\Exports\ExportFiles;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Region;
use App\Services\ConfigService;
use App\Services\Report\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public array $reportType = [];

    public function __construct()
    {
        $this->reportType = ['place', 'plate', 'invoice', 'welcome', 'backout', 'stayingAverage'];
    }

    public function index(Request $request)
    {
        return view("customer.reports.index", [
            'statistics' => ReportService::statistics($request->start, $request->end)
        ]);
    }

    public function show($type, Request $request)
    {
        if (!in_array($type, $this->reportType)) abort(404);

        try {
            $branches = Branch::active()->primary()->select('id', 'name')->with('areas')->get();
            $regions = Region::active()->primary()->child()->select('id', 'name')->get();
            $cities = Region::active()->primary()->parent()->select('id', 'name')->get();

            $filter = (empty($request->except('_token')) || is_null($request->show_by))
                ? $this->getTopBranch($type, $request->all())
                : $request->except('_token');

            $result = ReportService::handle($type, $filter);

            if ($result['type'] == 'region' || $result['type'] == 'city') {
                $list_report = Region::query();
            } else {
                $list_report = Branch::query();
            }

            $list_report = $list_report->active()->primary()->take(6)
                ->whereIn('id', \Arr::wrap($result['list']))
                ->pluck('name');

            return view("customer.reports.type.$type", [
                'branches_check' => $branches_check ?? [],
                'branches' => $branches,
                'regions' => $regions,
                'cities' => $cities,
                'list_report' => $list_report ?? [],
                'report' => $result,
                'config' => ConfigService::get($type),
                'filter_type' => 'comparison',
            ]);

        } catch (\Exception $e) {
            return unKnownError($e->getMessage());
        }
    }

    public function getTopBranch($type, $filter): array
    {
        $branches = DB::table("view_top_branch_place")->pluck('branch_id')->toArray();

        return [
            'start' => $filter['start'] ?? "2022-01-01",
            'end' => $filter['end'] ?? null,
            'show_by' => 'branch',
            'branch_type' => 'comparison',
            'branch_comparison' => $branches,
        ];
    }

    public function download($type, Request $request)
    {
        $filter = (empty($request->except('_token')) || is_null($request->show_by))
            ? $this->getTopBranch($type, $request->all())
            : $request->except('_token');
        $data = ReportService::handle($type, $filter);

        $result = $data['charts']['bar'];
        $start = $request->start ?? '2022-01-01';
        $end = $request->end_date ?? now()->toDateString();
        $name = "{$type}_excel_file_{$start}_to_{$end}.xls";

        $path = "reports/$type/files";
        $file_path = $path . '/' . $name;
        if (!is_dir(storage_path("/app/public/" . $path))) {
            \File::makeDirectory(storage_path("/app/public/" . $path), 777, true, true);
        }


        $check = \Excel::store(new ExportFiles($result), 'public/' . $file_path);

        if ($check) {
            $file = public_path() . "/storage/$file_path";
            return \Response::download($file, $name, ['Content-Type: application/xls']);
        }

        return redirect()->back()->with('danger', "Fail To Download File");
    }

    public function getBranchByRegion($region)
    {
        $branches = Branch::active()->primary()->where('region_id', $region)->select('id', 'name')->get();

        return view('customer.reports.extra._branch_by_region', ['branches' => $branches]);
    }

    public function getRegionByCity($city)
    {
        $regions = Region::active()->primary()->where('parent_id', $city)->select('id', 'name')->get();

        return view('customer.reports.extra._region_by_city', ['regions' => $regions]);
    }
}
