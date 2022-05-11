<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchMessageRequest;
use App\Models\BackoutReason;
use App\Models\Branch;
use App\Models\BranchFiles;
use App\Models\MessageLog;
use App\UserSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackoutReasonController extends Controller
{
    public function index(BranchMessageRequest $request)
    {
        $branches = DB::table('branches')
            ->select('branches.*')
            ->whereNull('branches.deleted_at')
            ->where('branches.active', true)
            ->where('branches.user_id', parentID())
            ->get();

        $userSettings = UserSetting::where('user_id', auth()->id())->first();

        $query = BackoutReason::query()->join('branches','branches.code','=','backout_reasons.station_code')
            ->when(($request->branch_code != null), function ($q) {
                return $q->where('station_code', \request('branch_code'));
            })->orderBy('backout_reasons.created_at','DESC');

        if ($request->start_date) {
            $query->whereDate('backout_reasons.created_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('backout_reasons.created_at', '<=', $request->end_date);
        }

        $data = $query->paginate(10);

        return view("customer.backout_reasons.index", compact('branches', 'data', 'userSettings'));
    }

    /**
     * @param $request
     * @return RedirectResponse
     */
    public function export($request)
    {
        $request = (object)$request;
        $current_branch = Branch::findOrFail($request->branch_id);
            $type = $request->type;

            $start_name = $request->start ?? 'first';
            $last_name = $request->end ?? 'last';
            $name = "{$current_branch->name}_file_from_{$start_name}_to_{$last_name}.$type";

            $file = BranchFiles::firstOrCreate([
                'start' => $request->start_date ?? null,
                'end' => $request->end_date ?? null,
//                'user_model_branch_id' => $current_branch->id,
                'branch_id' => $current_branch->id,
                'type' => $type,
                'model_type' => 'backout',
            ], [
                'name' => $name,
                'status' => false,
                'user_id' => auth()->id(),
            ]);

            if ($file->status && \Storage::disk('public')->exists($file->url)) {
                return redirect()->back()->with([
                    'success' => __('app.places.files_prepared_successfully'),
                    'branch_file' => Storage::disk('public')->url($file->url)
                ]);
            }
            return redirect()->back()->with('success', __('app.places.file_will_prepare_soon'));
    }

    public function exportedFile(Request $request)
    {
        $items = BranchFiles::when($request->has('branch_id'), function ($q) {
            return $q->where('branch_id', \request('branch_id'));
        })->where('user_id', parentID())
            ->where('model_type', 'backout')
            ->latest()
            ->paginate(10);

        return view('customer.branch_messages.files', compact('items'));
    }
}
