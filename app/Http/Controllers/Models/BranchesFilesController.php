<?php

namespace App\Http\Controllers\Models;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\BranchFileRepo;
use App\Models\BranchFiles;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BranchesFilesController extends Controller
{

    protected BranchFileRepo $repo;

    public function __construct(BranchFileRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param $branch_id
     * @param $usermodelbranchid
     * @return Application|Factory|View
     */
    public function index($branch_id, $usermodelbranchid)
    {
        $items = BranchFiles::where('branch_id', $branch_id)
            ->where('user_model_branch_id', $usermodelbranchid)
            ->where('user_id', parentID())
            ->latest()
            ->paginate(10);


        return view('customer.preview.files.index', compact('items'));

    }

    /**
     * @param $file
     * @return RedirectResponse
     */
    public function download($file)
    {
        $file = BranchFiles::findOrFail((int)$file);

        if (Storage::disk('public')->exists($file->url)) {
            return redirect()->back()->with([
                'success' => __('app.places.files_prepared_successfully'),
                'branch_file' => Storage::disk('public')->url($file->url)
            ]);
        }
        return redirect()->back()->with([
            'success' => __('app.places.file_not_found'),
            'branch_file' => null
        ]);
    }

    /**
     * @param $file
     * @return JsonResponse
     */
    public function destroy($file)
    {
        try {
            $this->repo->delete($file);

            return response()->json(['message' => __('app.success_delete_message'), 'alertmsg' => __('app.success')], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => __('app.cannotdelete'), 'alertmsg' => __('app.fail')], 500);
        }
    }
}
