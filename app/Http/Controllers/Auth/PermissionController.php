<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Spatie\Permission\Models\Permission;
use App\Http\Repositories\Eloquent\PermissionsRepo;
class PermissionController extends Controller
{
    protected $repo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PermissionsRepo $repo)
    {
        $this->middleware('permission:list-permissions|edit-permissions|delete-permissions|create-permissions', ['only' => ['index','store']]);
        $this->middleware('permission:create-permissions', ['only' => ['create','store']]);
        $this->middleware('permission:edit-permissions', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-permissions', ['only' => ['destroy','delete_all']]);
        $this->repo = $repo;
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $items=$this->repo->getAll();
        return view('auth.managements.permissions.index',compact('items'));
    }

    public function search(Request $request)
    {
        return Permission::where('name', 'like', '%' . $request->search . '%')
            ->orWhere('guard_name', 'like', '%' . $request->search . '%')
            ->orWhere('group', 'like', '%' . $request->search . '%')
            ->orWhere('display_name', 'like', '%' . $request->search . '%')->orderBy('id', 'DESC')->paginate(10);
    }
    public function create()
    {

        return view('auth.managements.permissions.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions',
            'display_name' => 'required',
            'group' => 'required',
        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $data=[
            'name' => $request->name,
            'display_name' => $request->display_name,
            'guard_name' => "web",
            'group' => $request->group,
        ];
        $insert=$this->repo->create($data);


        return redirect('/auth/permissions')->with('success',__('app.permissions.success_message'));
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
        return view('auth.managements.permissions.edit',compact('id','item'));

    }


    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required||unique:permissions,name,'.$id,
            'display_name' => 'required',
            'group' => 'required',
        ]);

        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $item = $this->repo->update($request->all(),$id);

        return redirect('/auth/permissions')->with('success',__('app.permissions.success_message'));
    }



    public function destroy(Request $request)
    {
        return $this->repo->delete($request->id);
    }


}
