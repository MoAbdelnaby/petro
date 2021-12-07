<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\BranchRepo;
use App\Models\ModelFeature;
use App\Models\Branch;
use App\Models\Region;
use App\Models\UserModelBranch;
use App\User;
use App\userSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Validator;
use App\Models\UserPackages;

class CustomerBranchesController extends Controller
{
    protected $repo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BranchRepo $repo)
    {
        $this->middleware('permission:list-CustomerBranches|edit-CustomerBranches|delete-CustomerBranches|create-CustomerBranches', ['only' => ['index', 'store']]);
        $this->middleware('permission:create-CustomerBranches', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-CustomerBranches', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-CustomerBranches', ['only' => ['destroy', 'delete_all']]);
        $this->repo = $repo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $user = Auth::user();
        if ($user->type == "subcustomer") {
            $branches = $user->branches->pluck('id')->toArray();
            if (!in_array($id, $branches)) {
                return redirect()->back()->with('danger', __('app.gym.empty_branch'));
            }
        } elseif ($user->type == "customer") {

            $item = $this->repo->findOrFail($id);

            if ($item->user_id != parentID()) {
                return redirect()->back()->with('danger', __('app.gym.empty_branch'));
            }
        }

        $activepackage = UserPackages::where('user_id', parentID())->where('active', '1')->first();

        $query = DB::table('user_model_branches')
            ->select(['user_model_branches.*', 'branches.name as bname', 'models.name as mname'])
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->join('models', 'models.id', '=', 'users_models.model_id')
            ->where('users_models.user_package_id', $activepackage->id)
            ->where('branches.id', $id);

        $count = $query->count();
        $items = $query->get();

        if ($count < 1) {
            return redirect()->back()->with('danger', __('app.customers.branchmodels.modelnotfound'));
        } else {
            return redirect()->route('branchmodelpreview.index', [$id]);
        }
    }


    public function index()
    {
        $items = $this->repo->getactiveBranches();

        $trashs = Branch::onlyTrashed()->where('user_id', parentID())->get();
        if (Auth::check()) {
            $userSettings = UserSetting::where('user_id', Auth::user()->id)->first();
        }
        return view('customer.branches.index', compact('items', 'userSettings', 'trashs'));
    }


    /**
     * Create the Package for dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $regions = Region::with('branches')->where('user_id', parentID())->where('active', true)->get();
        return view('customer.branches.create', compact('regions'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request_data = $request->validate([
            'name' => 'required|string|min:2|max:60|regex:/^[a-zA-Z ]+$/|unique:branches,name,NULL,id,deleted_at,NULL,user_id,' . auth()->id(),
            'photo' => 'nullable|image',
            'code' => 'required|unique:branches,code',
            'region_id' => 'required',
            'top' => 'sometimes|required',
            'left' => 'sometimes|required',
            'area_count' => 'required|numeric|min:1|max:9',
            'models' => 'required|array|min:2',
            'models.*' => 'required|numeric|in:3,4'
        ]);

        $data = Arr::except($request_data, ['region_id', 'photo']);

        try {

            DB::beginTransaction();

            if (is_numeric($request->region_id)) {
                $reg = Region::where('id',$request->region_id)->where('user_id', parentID())->first();
                if (!$reg) {
                    return redirect()->back()->with('danger', 'Region Not Found !');
                }
                $data['region_id'] = $request->region_id;
            } else {
                $old = Region::where('name', $request->region_id)->where('user_id', parentID())->first();
                if ($old) {
                    return redirect()->back()->with('danger', __('Region Name Used before'));
                }
                $reg = Region::create([
                    'name' => $request->region_id,
                    'user_id' => auth()->user()->id

                ]);
                $data['region_id'] = $reg->id;
            }

            if ($request->has('photo') && array_key_exists('photo', $validator->validated())) {
                $image = $request->file('photo');
                $fileName = time() . rand(0, 999999999) . '.' . $image->getClientOriginalExtension();
                $request->photo->storeAs('branches', $fileName, 'public');
                $data = array_merge($data, ['photo' => 'branches/' . $fileName]);
            }
            $params = Arr::except(array_merge($data, ['user_id' => auth()->user()->id]), 'models');

            $branch = $this->repo->create($params);

            collect($request->models)->each(function ($item) use ($branch) {
                UserModelBranch::create([
                    'branch_id' => $branch->id,
                    'user_model_id' => $item
                ]);
            });

            for ($i = 1; $i <= $request->area_count; $i++) {

                $branch->areas()->firstOrCreate([
                    'area' => $i,
                    'branch_code' => $branch->code,
                ], [
                    'status' => 0
                ]);
            }

            DB::commit();
            return redirect()->route('customerBranches.index')->with('success', __('app.customers.branches.success_message'));

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('customerBranches.index')->with('danger', $e->getMessage());

        }

    }

    /**
     * update the Permission for dashboard.
     *
     * @param Permission $permission
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $item = $this->repo->findOrFail($id);
        $regions = Region::with('branches')->where('user_id', parentID())->where('active', true)->get();
        return view('customer.branches.edit', compact('id', 'item', 'regions'));

    }

    /**
     * Update a resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:60|regex:/^[a-zA-Z ]+$/|unique:branches,name,' . $id . ',id,deleted_at,NULL,user_id,' . auth()->id(),
            'photo' => 'nullable|image',
            'region_id' => 'required',
            'top' => 'required',
            'left' => 'required',
            'area_count' => 'required|numeric|min:1|max:9',
            'code' => 'required|unique:branches,code,' . $id
        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $data = Arr::except($validator->validated(), ['photo', 'region_id']);

        try {

            DB::beginTransaction();

            if (is_numeric($request->region_id)) {
                $reg = Region::where($request->region_id)->where('user_id', parentID());
                if (!$reg) {
                    return redirect()->back()->with('danger', 'Region Not Found !');
                }
                $data['region_id'] = $request->region_id;
            } else {
                $old = Region::where('name', $request->region_id)->where('user_id', parentID())->first();
                if ($old) {
                    return redirect()->back()->with('danger', __('Region Name Used before'));
                }
                $reg = Region::create([
                    'name' => $request->region_id,
                    'user_id' => auth()->user()->id
                ]);
                $data['region_id'] = $reg->id;
            }

            if ($request->has('photo') && array_key_exists('photo', $validator->validated())) {
                $branch = Branch::findOrFail($id);
                Storage::disk('public')->delete($branch->photo);
                $image = $request->file('photo');
                $fileName = time() . rand(0, 999999999) . '.' . $image->getClientOriginalExtension();
                $request->photo->storeAs('branches', $fileName, 'public');
                $data = array_merge($data, ['photo' => 'branches/' . $fileName]);
            }

            $params = array_merge($data, ['user_id' => auth()->user()->id]);

            $branch = Branch::whereId($id)->with('areas')->first();

            $old_area_count = $branch->area_count; //old branch area count
            $new_area_count = $request->area_count; //new branch area count
            $this->repo->update($params, $id);

            $branch->areas()->update(['branch_code' => $branch->code]);

            if ($old_area_count != $new_area_count) {

                $diffCreate = $new_area_count > $old_area_count;
                $diffDelete = $new_area_count < $old_area_count;

                if ($diffCreate) { //check if area incresed
                    for ($i = $old_area_count + 1; $i <= $new_area_count; $i++) {
                        $branch->areas()->firstOrCreate([
                            'area' => $i,
                            'branch_code' => $branch->code,
                        ], [
                            'status' => 0
                        ]);
                    }
                }

                if ($diffDelete) { //check if area decresed
                    for ($i = $old_area_count; $i > $new_area_count; $i--) {
                        $branch->areas()->where('area', $i)->delete();
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return redirect()->route('customerBranches.index')->with('success', __('app.customers.branches.updated_message'));

    }

    /**
     * Delete more than one permission.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $this->repo->delete($request->id);
            return response()->json(['message' => __('app.success_delete_message'), 'alertmsg' => __('app.success')], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => __('app.cannotdelete'), 'alertmsg' => __('app.fail')], 500);
        }

    }

    public function restore(Request $request)
    {
        try {
            $this->repo->bulkRestore($request->trashs);
            return redirect()->route('customerBranches.index')->with('success', __('app.success_restore_message'));
        } catch (\Exception $e) {
            return redirect()->route('customerBranches.index')->with('danger', __('app.cannotrestore'));
        }
    }

    public function forceDelete(Request $request)
    {
        try {
            $this->repo->bulkForceDelete($request->trashs);
            return redirect()->route('customerBranches.index')->with('success', __('app.success_delete_message'));
        } catch (\Exception $e) {
            return redirect()->route('customerBranches.index')->with('danger', __('app.cannotdelete'));
        }
    }

    //    change active
    public function changeActive($id)
    {
        $item = $this->repo->findOrFail($id);
        $item->active = !$item->active;
        $item->save();
        return redirect()->back();

    }

}
