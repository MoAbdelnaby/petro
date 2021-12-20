<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\BranchRepo;
use App\Http\Repositories\Eloquent\CustomerRepo;
use App\Http\Repositories\Eloquent\UsersRepo;
use App\Models\Branch;
use App\Models\ModelFeature;
use App\Models\Region;
use App\Models\UserModelBranch;
use App\Models\UserWatchModels;
use App\Notifications\AdminNotifications;
use App\Notifications\assigendNotification;
use App\User;
use App\UserSetting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $usersRepo;
    protected $packageRepo;
    protected $branchRepo;

    public function __construct(UsersRepo $usersRepo, CustomerRepo $packageRepo, BranchRepo $branchRepo)
    {
        $this->middleware('permission:list-CustomerUsers|edit-CustomerUsers|delete-CustomerUsers|create-CustomerUsers', ['only' => ['index', 'store']]);
        $this->middleware('permission:create-CustomerUsers', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-CustomerUsers', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-CustomerUsers', ['only' => ['destroy', 'delete_all']]);
        $this->usersRepo = $usersRepo;
        $this->packageRepo = $packageRepo;
        $this->branchRepo = $branchRepo;

    }


    public function index()
    {
        $users = $this->usersRepo->getRelative(parentID());
        $trashs = User::onlyTrashed()->where('parent_id', parentID())->where('type', 'subcustomer')->get();
        $userWatchModels = UserWatchModels::with('usermodelbranch')->get();
        $regions = Region::with('branches')->where('user_id', parentID())->where('active', true)->get();

        $package = $this->packageRepo->getactivePackage();

        if (Auth::check()) {
            $userSettings = UserSetting::where('user_id', Auth::user()->id)->first();
        }

        if ($package) {
            $items = $this->packageRepo->getPackagesItems($package->id);

            $result = [];
            foreach ($items as $item) {

                $assignedbranches = UserModelBranch::with('usermodel')->with('branch')->where('active', 1)->where('user_model_id', $item->id)->get();

                foreach ($assignedbranches as $assignedbranch) {
                    $result[] = $assignedbranch;
                }
            }

            $userModelBranches = $result;

            $branches = Branch::where('user_id', parentID())->get();


        } else {
            $userModelBranches = [];
            $branches = [];
        }

        return view('customer.users.index', compact('trashs', 'regions', 'users', 'userModelBranches', 'userWatchModels', 'branches', 'userSettings'));
    }

    public function create()
    {
        return view('customer.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:70|email|unique:users|regex:/^\S+@\S+\.\S+$/',
            'name' => 'required|string|min:2|max:60|regex:/^[a-zA-Z ]+$/',
            'phone' => 'nullable|string|min:11|max:13|unique:users,phone|regex:/^[0-9\-\(\)\/\+\s]*$/',
            'password' => 'required|min:8|confirmed',
            'speedtest' => 'nullable',
        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => 'subcustomer',
            'password' => $request->password,
            'parent_id' => parentID()
        ];

        if ($request->has('speedtest') && $request->speedtest == 'on') {
            $data['speedtest'] =  1;
        }

        $user = User::create($data);
        $user->syncRoles('customer');

        /*notification to admins*/
        $admins = User::where('type','admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new AdminNotifications($user,Auth::user()->name));
        }
        /*end */

//        dd($user);
        return redirect('/customer/customerUsers')->with('success', __('app.users.success_create_message'));

    }

    /**
     * update the Permission for dashboard.
     *
     * @param Request $request
     * @return Builder|Model|object
     */
    public function edit($id)
    {

        $user = User::with('roles')->where('id', $id)->first();
        return view('customer.users.edit', compact('id', 'user'));

    }


    /**
     * update a permission.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:70|email|regex:/^\S+@\S+\.\S+$/|unique:users,email,' . $id,
            'name' => 'required|string|min:2|max:60|regex:/^[a-zA-Z ]+$/',
            'phone' => 'nullable|min:11|max:13|regex:/^[0-9\-\(\)\/\+\s]*$/|unique:users,phone,' . $id,
            'password' => 'sometimes|nullable|min:8|confirmed',
        ]);

        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $user = User::where('id', $id)->first();
        $data  = $validator->validated();
        if ($request->has('speedtest') && $request->speedtest == 'on') {
            $data['speedtest'] =  1;
        }else{
            $data['speedtest'] =  0;
        }

        if($request->has('password')){
            if(is_null($request->password)){
                $data = Arr::except($data,['password']);
            }
        }

        if ($user) {
            $user->update($data);
        }

        return redirect('/customer/customerUsers')->with('success', __('app.users.success_update_message'));
    }

    /**
     * Delete more than one permission.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        if ($user && $user->id != parentID() && $user->id != primaryID()) {
            activity()
                ->causedBy(auth()->user())
                ->inLog('user')
                ->performedOn($user)
                ->withProperties(['deleted_at' => Carbon::now()->format('Y-m-d H:i:s')])
                ->log(auth()->user()->name . ' Deleted - ' . $user->name ?? $user->id);

            $user->delete();
            return response()->json(['message' => __('app.success_delete_message'), 'alertmsg' => __('app.success')], 200);
        }
        return response()->json(['message' => __('app.cannotdelete'), 'alertmsg' => __('app.fail')], 500);
    }

    public function assignUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'user_model_branch_id' => 'required|exists:user_model_branches,id',
        ]);

        if ($validator->errors()->count()) {
            return redirect()->back()->with('danger', $validator->errors());
        }

        UserWatchModels::firstOrCreate(
            [
                'user_id' => $request->user_id,
                'user_model_branch_id' => $request->user_model_branch_id
            ]
        );
        return redirect()->back()->with('success', 'User Assigned Successfully');

    }

    public function assignUserToBranch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'branches' => 'required|array',
            'branches.*' => 'required|exists:branches,id',
        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $user = User::where('id', $request->user_id)->first();
        $user->branches()->sync($request->branches);
        /*notification*/
        $user->notify(new assigendNotification($request->branches, Auth::user()->name));
        /*end notification*/
        return redirect()->back()->with('success', 'User Assigned Successfully');

    }

    public function myModels()
    {
        $userWatchModels = UserWatchModels::with('usermodelbranch')->where('user_id', auth()->user()->id)->get();
        $result = [];
        foreach ($userWatchModels as $item) {
            $modelfeatures = json_decode($item->usermodelbranch->usermodel->features);
            $featurename = [];
            $featurerecord = [];
            if ($modelfeatures) {
                foreach ($modelfeatures as $modelfeature) {
                    $modelfeaturerecord = ModelFeature::with('feature')->find($modelfeature);
                    $featurename[] = $modelfeaturerecord->feature->name;
                    $featurerecord[] = $modelfeaturerecord->feature;
                }
            }

            $item->featurenames = $featurename;
            $item->featurerecord = $featurerecord;
            $item->modelfeaturerecord = $modelfeaturerecord;
            $result[] = $item;
        }
        $userWatchModels = $result;
        return view('customer.users.myModels', compact('userWatchModels'));
    }

    public function myBranches()
    {
        $user = Auth::user();
        $items = $user->branches;
        return view('customer.users.myBranches', compact('items'));
    }

    public function restore(Request $request)
    {
        try {
            $this->usersRepo->bulkRestore($request->trashs);
            return redirect()->route('customerUsers.index')->with('success', __('app.success_restore_message'));
        } catch (\Exception $e) {
            return redirect()->route('customerUsers.index')->with('danger', __('app.cannotrestore'));
        }
    }

    public function forceDelete(Request $request)
    {
        try {
            $this->usersRepo->bulkForceDelete($request->trashs);
            return redirect()->route('customerUsers.index')->with('success', __('app.success_delete_message'));
        } catch (\Exception $e) {
            return redirect()->route('customerUsers.index')->with('danger', __('app.cannotdelete'));
        }
    }


}
