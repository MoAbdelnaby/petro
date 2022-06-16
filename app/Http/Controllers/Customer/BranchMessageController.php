<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchMessageRequest;
use App\Models\Branch;
use App\Models\BranchFiles;
use App\Models\MessageLog;
use App\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BranchMessageController extends Controller
{
    public function index(BranchMessageRequest $request)
    {
        if (in_array($request->type, ['pdf', 'xls'])) {
            return $this->export($request->all());
        }

        $branches = DB::table('branches')
            ->select('branches.*')
            ->whereNull('branches.deleted_at')
            ->where('branches.active', true)
            ->where('branches.user_id', parentID())
            ->get();

        $userSettings = UserSetting::where('user_id', auth()->id())->first();

        $query = MessageLog::with('branch')
            ->when(($request->branch_id != null), function ($q) {
                return $q->where('branch_id', \request('branch_id'));
            })->latest();

        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->message_type) {
            $query->where('type', $request->message_type);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $data = $query->paginate(10);

        return view("customer.branch_messages.index", compact('branches', 'data', 'userSettings'));
    }

    public function export($request)
    {
        $request = (object)$request;
        $current_branch = Branch::where('id',$request->branch_id)->first();
        $type = $request->type;

        $start_name = $request->start_date ?? 'first';
        $last_name = $request->end_date ?? 'last';
        $name = "{$current_branch->name}_file_from_{$start_name}_to_{$last_name}.$type";

        $file = BranchFiles::firstOrCreate([
            'start' => $request->start_date ?? null,
            'end' => $request->end_date ?? null,
            'branch_id' => $current_branch->id,
            'type' => $type,
            'model_type' => 'message',
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
        return redirect(route('branch.message_log'))->with('success', __('app.places.file_will_prepare_soon'));
    }

    public function exportedFile(Request $request)
    {
        $items = BranchFiles::when($request->has('branch_id'), function ($q) {
            return $q->where('branch_id', \request('branch_id'));
        })->where('user_id', parentID())
            ->where('model_type', 'message')
            ->latest()
            ->paginate(10);

        return view('customer.branch_messages.files', compact('items'));
    }
}
