<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\BranchRepo;
use App\Http\Repositories\Eloquent\CustomerRepo;
use App\Http\Repositories\Eloquent\UsersRepo;
use App\Http\Requests\UserRequest;
use App\Models\Branch;
use App\Models\ModelFeature;
use App\Models\Position;
use App\Models\Region;
use App\Models\UserModelBranch;
use App\Models\UserWatchModels;
use App\Notifications\AdminNotifications;
use App\Notifications\assigendNotification;
use App\User;
use App\UserSetting;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @return void
     */
    protected UsersRepo $usersRepo;
    protected CustomerRepo $packageRepo;
    protected BranchRepo $branchRepo;

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

    /**
     * @return View|JsonResponse|RedirectResponse
     */
    public function index()
    {
        try {
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

        } catch (\Exception $e) {
            return unKnownError($e->getMessage());
        }
    }

    /**
     * @return View
     */
    public function create()
    {
        $positions = Position::primary()->get();

        return view('customer.users.create', compact('positions'));
    }

    /**
     * @param UserRequest $request
     * @return Redirector|RedirectResponse
     */
    public function store(UserRequest $request)
    {
        try {
            $data = $request->validated();
            $data['parent_id'] = parentID();
            $data['speedtest'] = ($request->speedtest == 'on');

            $user = $this->usersRepo->create($data);
            $user->syncRoles('customer');

            /*Notification to admins*/
            $admins = User::where('type', 'customer')->get();
            foreach ($admins as $admin) {
                $admin->notify(new AdminNotifications($user, Auth::user()->name));
            }

            return redirect('/customer/customerUsers')->with('success', __('app.users.success_create_message'));

        } catch (\Exception $e) {
            return unKnownError($e->getMessage());
        }
    }

    /**
     * @param $id
     * @return View|RedirectResponse
     */
    public function edit($id)
    {
        try {
            $user = User::where('id',$id)->with('roles')->first();
            $positions = Position::primary()->get();

            if ((auth()->user()->type == "subadmin" && $user->type != "subadmin") || auth()->user()->type == "customer") {
                return view('customer.users.edit', compact( 'user', 'positions'));
            }

            return redirect()->back()->with('danger', 'Can not edit this user');
        } catch (\Exception $e) {
            return unKnownError($e->getMessage());
        }
    }

    /**
     * @param UserRequest $request
     * @param $id
     * @return RedirectResponse|Redirector|void
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $user = User::find($id);

            if ((auth()->user()->type == "subadmin" && $user->type != "subadmin") || auth()->user()->type == "customer") {

                $data = $request->validated();
                $data['speedtest'] = ($request->speedtest == 'on');

                if (is_null($request->password)) {
                    $data = Arr::except($data, ['password']);
                }

                $user->update($data);

                return redirect('/customer/customerUsers')->with('success', __('app.users.success_update_message'));
            }
            abort(403);
        } catch (\Exception $e) {
            return unKnownError($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        if ((auth()->user()->type == "subadmin" && $user->type != "subadmin") || auth()->user()->type == "customer") {
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
        }
        return response()->json(['message' => __('app.cannotdelete'), 'alertmsg' => __('app.fail')], 500);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
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
            ['user_id' => $request->user_id, 'user_model_branch_id' => $request->user_model_branch_id]
        );
        return redirect()->back()->with('success', 'User Assigned Successfully');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
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

    /**
     * @return Factory|View
     */
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

    /**
     * @return Application|Factory|View
     */
    public function myBranches()
    {
        $user = Auth::user();
        $items = $user->branches;

        return view('customer.users.myBranches', compact('items'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function restore(Request $request)
    {
        try {
            $this->usersRepo->bulkRestore($request->trashs);
            return redirect()->route('customerUsers.index')->with('success', __('app.success_restore_message'));
        } catch (\Exception $e) {
            return redirect()->route('customerUsers.index')->with('danger', __('app.cannotrestore'));
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function forceDelete(Request $request)
    {
        try {
            $this->usersRepo->bulkForceDelete($request->trashs);
            return redirect()->route('customerUsers.index')->with('success', __('app.success_delete_message'));
        } catch (\Exception $e) {
            return redirect()->route('customerUsers.index')->with('danger', __('app.cannotdelete'));
        }
    }

    /**
     * @return Application|Factory|View
     */
    public function UserSetting()
    {
        $user = Auth::user();
        $notify = $user->mail_notify;
        return view('settings.user.setting', ['notify' => $notify]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function MailsettingUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mail_notify' => 'required|in:on,off',
        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $user = Auth::user();
        $user->update($validator->validated());
        return redirect()->back()->with('success', __('app.mail_status_success'));
    }

}
