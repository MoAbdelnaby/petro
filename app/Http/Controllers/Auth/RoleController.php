<?php

namespace App\Http\Controllers\Auth;

use App\Datatables\Datatable;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\RoleRepo;
use App\Role;
use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    protected $repo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RoleRepo $repo)
    {
        $this->middleware('permission:list-roles|edit-roles|delete-roles|create-roles', ['only' => ['index', 'store']]);
        $this->middleware('permission:create-roles', ['only' => ['create','store']]);
        $this->middleware('permission:edit-roles', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-roles', ['only' => ['destroy', 'delete_all']]);
        $this->repo = $repo;
    }

    public function data()
    {
        return Datatable::datatable(Role::get());
    }
    public function search(Request $request)
    {
        return Role::whereNotIn('name', ['admin.Root','admin.Admin','customer'])
            ->where(function($q)  use ($request) {
            $q->where('guard_name', 'like', '%' . $request->search . '%')
            ->orWhere('display_name', 'like', '%' . $request->search . '%')
            ->orWhere('name', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'DESC')->paginate(10);
    }
    public function permissions($id)
    {
        return Role::find($id)->permissions ?? null;
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $permissions = new Collection();
        foreach (auth()->user()->roles()->with('permissions')->get() as $role) {
            $permissions = $permissions->union($role->permissions);
        }
        $groups = [];
        $groups2 = [];
        $items=$this->repo->getAll();
        return view('auth.managements.roles.index', compact('permissions', 'groups', 'groups2','items'));
    }
    public function create()
    {

        return view('auth.managements.roles.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:2|max:60|unique:roles',
                'display_name' => 'required|min:2',
            ]);
            if ($validator->errors()->all()) {
                return response()->json(['errors' => $validator->errors()], 500);
            }
            $role = Role::create([
                'name' => primarySlug() . '.' . $request->name,
                'display_name' => $request->display_name,
                'guard_name' => "web",
            ]);
            $role->syncPermissions($request->permissions);

            session()->put('success', __('app.roles.success_message'));
            return response()->json(['success' => 'Done']);
        }
    }

    /**
     * update the Role for dashboard.
     *
     * @param Request $request
     * @return Builder|Model|object
     */
    public function edit(Request $request)
    {
        $roles = Role::with('permissions')->where('id', $request->id)->first();
        if ($roles) {
            return $roles;
        }
    }

    /**
     * update a permission.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:60|unique:roles,name,' . $request->id,
            'display_name' => 'required|min:2',
        ]);

        if ($validator->errors()->count()) {
            return response()->json(['errors' => $validator->errors()], 500);
        }

        $role = Role::where('id', $request->id)->first();
        $role->syncPermissions($request->permissions);

        if ($role) {
            if (strpos($request->name, primarySlug() . '.') === false) {
                $request->name = primarySlug() . '.' . $request->name;
            }

            $role->update([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'guard_name' => "web",
            ]);
        }
        session()->put('success', __('app.roles.success_message'));
        return response()->json(['success' => 'Done']);
    }


    /**
     * Delete more than one roles.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {

        $role = Role::where('id', $request->id)->first();

        if (User::where('id', primaryID())->first()->hasRole($role)) {
            return 'You Can not delete Admin Roles';
        }

        if ($role) {
            return $this->repo->delete($request->id);
        }


    }


    /**
     * Delete a permission.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete_all(Request $request)
    {
        foreach ($request->ids as $id) {
            $role = Role::where('id', $id)->first();

            if (User::where('id', primaryID())->first()->hasRole($role)) {
                return response()->json(['message' => 'You Can not delete Admin Roles'], 419);
            }

            if ($role) {
                $role->delete();
            }
        }

        session()->put('success', __('app.roles.delete_success_message'));
        return response()->json(['message' => "success"]);
    }
}
