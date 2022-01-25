<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\RegionRepo;
use App\Models\Region;
use App\Notifications\regionNotification;
use App\User;
use App\userSetting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Validator;

class RegionController extends Controller
{
    protected RegionRepo $repo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RegionRepo $repo)
    {
//        $this->middleware('permission:list-regions|edit-CustomerBranches|delete-CustomerBranches|create-CustomerBranches', ['only' => ['index','store']]);
//        $this->middleware('permission:create-regions', ['only' => ['create','store']]);
//        $this->middleware('permission:edit-regions', ['only' => ['edit','update']]);
//        $this->middleware('permission:delete-regions', ['only' => ['destroy','delete_all']]);
        $this->repo = $repo;
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        $items = Region::orderBy('id', 'DESC')->with('parent')->get();
        $trashs = Region::onlyTrashed()->where('user_id', parentID())->get();

        if (Auth::check()) {
            $userSettings = UserSetting::where('user_id', Auth::user()->id)->first();
        }

        return view('customer.regions.index', compact('items', 'userSettings', 'trashs'));
    }

    /**
     * Create the Package for dashboard.
     *
     * @return Renderable
     */
    public function create(): Renderable
    {
        $regions = Region::whereNull('parent_id')->where('user_id', parentID())->where('active', true)->get();

        return view('customer.regions.create', compact('regions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:60|unique:regions,name,NULL,id,deleted_at,NULL,user_id,' . auth()->id(),
            'photo' => 'nullable|image',
            'parent_id' => 'required|exists:regions,id',
        ]);

        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $data = Arr::except($validator->validated(), ['photo']);
        if ($request->has('photo') && array_key_exists('photo', $validator->validated())) {
            $image = $request->file('photo');
            $fileName = time() . rand(0, 999999999) . '.' . $image->getClientOriginalExtension();
            $request->photo->storeAs('regions', $fileName, 'public');
            $data = array_merge($data, ['photo' => 'regions/' . $fileName]);
        }

        $params = array_merge($data, ['user_id' => auth()->user()->id, 'display_name' => $data['name'] ?? '']);
        $insert = $this->repo->create($params);
        if ($insert) {
            foreach (User::where('type', 'customer')->get() as $user) {
                $user->notify(new regionNotification($insert, Auth::user()->name));
            }
        }

        return redirect()->route('customerRegions.index')->with('success', __('app.customers.regions.success_message'));
    }

    /**
     * update the Permission for dashboard.
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $item = $this->repo->findOrFail($id);

        $regions = Region::whereNull('parent_id')
            ->where('user_id', parentID())
            ->where('active', true)->get();

        return view('customer.regions.edit', compact('id', 'item', 'regions'));
    }

    /**
     * Update a resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:60|unique:branches,name,' . $id . ',id,deleted_at,NULL,user_id,' . auth()->id(),
            'photo' => 'nullable|image',
            'parent_id' => 'nullable|exists:regions,id',
        ]);

        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $region = Region::findOrFail($id);
        if($region->parent_id == null && $request->parent_id != null){
            return redirect()->back()->withErrors(['parent_id' => "You can't add parent for this region"])->withInput();
        }

        if($region->parent_id != null && $request->parent_id == null){
            return redirect()->back()->withErrors(['parent_id' => "You must add parent for this region"])->withInput();
        }

        $data = Arr::except($validator->validated(), ['photo']);

        if ($request->has('photo') && array_key_exists('photo', $validator->validated())) {

            Storage::disk('public')->delete($region->photo);
            $image = $request->file('photo');
            $fileName = time() . rand(0, 999999999) . '.' . $image->getClientOriginalExtension();
            $request->photo->storeAs('regions', $fileName, 'public');
            $data = array_merge($data, ['photo' => 'regions/' . $fileName]);
        }

        $params = array_merge($data, ['user_id' => auth()->user()->id]);

        $this->repo->update($params, $id);

        return redirect()->route('customerRegions.index')->with('success', __('app.customers.regions.success_message'));
    }

    /**
     * Delete more than one permission.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        try {
            $reagoin = $this->repo->findOrFail($request->id);
            $reagoin->delete($request->id);
            $reagoin->branches()->delete();
            return response()->json(['message' => __('app.success_delete_message'), 'alertmsg' => __('app.success')]);
        } catch (\Exception $e) {
            return response()->json(['message' => __('app.cannotdelete'), 'alertmsg' => __('app.fail')], 500);
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function restore(Request $request): RedirectResponse
    {
        try {
            $allRows = Region::onlyTrashed()->find($request->trashs);
            if ($allRows) {
                foreach ($allRows as $row) {
                    $row->restore();
                    $row->branches()->withTrashed()->restore();
                }
            }
            return redirect()->route('customerRegions.index')->with('success', __('app.success_restore_message'));
        } catch (\Exception $e) {
            return redirect()->route('customerRegions.index')->with('danger', __('app.cannotrestore'));
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function forceDelete(Request $request): RedirectResponse
    {
        try {
            $allRows = Region::onlyTrashed()->find($request->trashs);
            if ($allRows) {
                foreach ($allRows as $row) {
                    $row->forceDelete();
                    $row->branches()->forceDelete();
                }
            }
            return redirect()->route('customerRegions.index')->with('success', __('app.success_delete_message'));
        } catch (\Exception $e) {
            return redirect()->route('customerRegions.index')->with('danger', __('app.cannotdelete'));
        }
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function changeActive($id): RedirectResponse
    {
        $item = $this->repo->findOrFail($id);
        $item->active = !$item->active;
        $item->save();
        return redirect()->back();
    }
}
