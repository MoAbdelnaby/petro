<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageItems;
use App\Models\PackageUserLog;
use App\Models\UserModel;
use App\Models\UserPackages;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Http\Repositories\Eloquent\UsersRepo;
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


    public function __construct(UsersRepo $usersRepo)
    {
        $this->middleware('permission:list-users|edit-users|delete-users|create-users', ['only' => ['index', 'store']]);
        $this->middleware('permission:create-users', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-users', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-users', ['only' => ['destroy', 'delete_all']]);
        $this->usersRepo = $usersRepo;
    }


    public function roles($id)
    {
        return User::find($id)->roles ?? null;
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $roles = Role::all();
        $users = $this->usersRepo->getAll();

        return view('auth.managements.users.index', compact('roles', 'users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('auth.managements.users.create', compact('roles'));
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
            'email' => 'required|max:60|email' . (User::where('email', $request->email)->first() ? '|unique:users,email' : ''),
            'name' => 'required|string|min:2|max:60|regex:/^[a-zA-Z ]+$/||regex:/^[a-zA-Z ]+$/',
            'phone' => 'nullable|min:11|max:13',
            'type' => 'required',
            'password' => 'required|min:8|confirmed',
            'package' => 'nullable',
        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $user = User::withTrashed()->firstOrCreate([
            'email' => $request->email,
        ], [
            'name' => $request->name,
            'password' => $request->password,
            'systempass' => 'petro@wakeb2030',
            'type' => $request->type,
            'parent_id' => primaryID(),
            'phone' => $request->phone,
        ]);
        $user->restore();
        $user->save();
        $user->refresh();

        if ($request->has('package') && $request->package == 'on') {
            $package = Package::where('name', 'Petromin')->where('active', true)->first();
            $curent = UserPackages::where('user_id', $user->id)->where('active', 1)->first();
            UserPackages::where('user_id', $user->id)->where('active', 1)->update([
                'active' => 0
            ]);
            if ($curent) {
                UserModel::where('user_package_id', $curent->id)->delete();
            }
            $insert = UserPackages::create([
                'name' => $package->name,
                'desc' => $package->desc,
                'price_monthly' => $package->price_monthly,
                'price_yearly' => $package->price_yearly,
                'type' => $package->type,
                'is_offer' => $package->is_offer,
                'payment_status' => 0,
                'user_id' => $user->id,
                'start_date' => \Carbon\Carbon::now()->isoFormat('YYYY-MM-DD'),
                'end_date' => $package->end_date
            ]);
            $items = $this->getItems($package->id);

            foreach ($items as $item) {
                UserModel::create([
                    'model_id' => $item->model_id,
                    'user_package_id' => $insert->id,
                    'features' => $item->features,
                    'count' => $item->count,
                ]);
            }
            PackageUserLog::create([
                'package_id' => $package->id,
                'user_package_id' => $insert->id,
                'user_id' => $user->id,
            ]);
        }

//        $user = User::create([
//            'name' => $request->name,
//            'email' => $request->email,
//            'phone' => $request->phone,
//            'type' => $request->type,
//            'password' => Hash::make($request->password),
//            'parent_id' => primaryID()
//        ]);


        if ($request->type == 'customer' || $request->type == 'subcustomer') {
            $user->syncRoles('customer');
        } else {
            $user->syncRoles($request->roles);
        }

        return redirect('/auth/users')->with('success', __('app.users.success_message'));

    }


    public function getItems($packageid)
    {
        return PackageItems::with('model')->where('package_id', $packageid)->orderBy('id', 'DESC')->paginate(10);
    }


    /**
     * update the Permission for dashboard.
     *
     * @param Request $request
     * @return Builder|Model|object
     */
    public function edit($id)
    {
        $roles = Role::all();
        $user = User::with('roles')->where('id', $id)->first();
        return view('auth.managements.users.edit', compact('id', 'user', 'roles'));

    }

    public function show()
    {
        $user = User::where('id', auth()->user()->id)->first();
        return view('auth.managements.users.profile', compact('user'));

    }

    public function changepassword($id)
    {
        $user = User::where('id', auth()->user()->id)->first();
        return view('auth.managements.users.changepassword', compact('user'));

    }

    public function editchangepassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldpassword' => ['required', 'min:8', new MatchOldPassword],
            'password' => 'required|min:8|confirmed'
        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        User::find(auth()->user()->id)->update(['password' => $request->password]);

        return redirect('/auth/users/changepassword/' . auth()->user()->id)->with('success', __('app.change_success_message'));

    }

    public function updateprofile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|max:50|email|regex:/^\S+@\S+\.\S+$/|unique:users,email,' . auth()->user()->id,
            'name' => 'required|string|min:2|max:60|regex:/^[a-zA-Z ]+$/',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'phone' => 'nullable|min:11|max:13',
//            'phone' => 'nullable|regex:/^[0-9\-\(\)\/\+\s]*$/',
        ]);

        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $user = User::where('id', auth()->user()->id)->first();

        if ($user) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone
            ]);
            if ($request->has('avatar')) {
                $image = $request->file('avatar');
                $fileName = time() . rand(0, 999999999) . '.' . $image->getClientOriginalExtension();
                $request->avatar->storeAs('profile', $fileName, 'public');
                $user->avatar = 'profile/' . $fileName;
                $user->save();
            }

            if ($user->type == 'customer' || $user->type == 'subcustomer') {
                $user->syncRoles('customer');
            } else {
                $user->syncRoles($request->roles);
            }
        }

        return redirect()->route('users.profile')->with('success', __('app.profile_success_message'));
    }

    /**
     * update a permission.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|regex:/^\S+@\S+\.\S+$/|unique:users,email,' . $id,
            'name' => 'required|string|min:2|max:60|regex:/^[a-zA-Z ]+$/',
            'phone' => 'nullable|min:11|max:13|regex:/^[0-9\-\(\)\/\+\s]*$/',
            'type' => 'required',
            'password' => 'sometimes|confirmed',
        ]);

        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $user = User::where('id', $id)->first();
        $data  = $validator->validated();
        $data = Arr::add($data,['systempass' => 'petro@wakeb2030']);
        if($request->has('password')){
            if(is_null($request->password)){
                $data = Arr::except($data,['password']);
            }
        }
        if ($user) {
            $user->update($data);

            if ($request->type == 'customer' || $request->type == 'subcustomer') {
                $user->syncRoles('customer');
            } else {
                $user->syncRoles($request->roles);
            }
        }

        return redirect('/auth/users')->with('success', __('app.users.success_message'));
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

        if ($user && $user->id != auth()->user()->id && $user->id != primaryID()) {
            activity()
                ->causedBy(auth()->user())
                ->inLog('user')
                ->performedOn($user)
                ->withProperties(['deleted_at' => Carbon::now()->format('Y-m-d H:i:s')])
                ->log(auth()->user()->name . ' Deleted - ' . $user->name ?? $user->id);
            $user->delete();
        } else {
            return __('app.users.cannotdelete');
        }
        return 1;
    }

    public function search(Request $request)
    {
        return User::with('user')->where('email', 'like', '%' . $request->search . '%')
            ->orWhere('phone', 'like', '%' . $request->search . '%')
            ->orWhere('name', 'like', '%' . $request->search . '%')->orderBy('id', 'DESC')->paginate(10);
    }


}
