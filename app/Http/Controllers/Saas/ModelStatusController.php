<?php

namespace App\Http\Controllers\Saas;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\ModelstatusRepo;
use App\Models\Models;
use Illuminate\Http\Request;
use Validator;
use App\Models\ModelStatus;
use App\User;
class ModelStatusController extends Controller
{
    protected $repo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ModelstatusRepo $repo)
    {
        $this->middleware('permission:list-modelstatus|edit-modelstatus|delete-modelstatus|create-modelstatus', ['only' => ['index','store']]);
        $this->middleware('permission:create-modelstatus', ['only' => ['create','store']]);
        $this->middleware('permission:edit-modelstatus', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-modelstatus', ['only' => ['destroy','delete_all']]);
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
        return view('saas.modelstatus.index',compact('items'));
    }

    public function search(Request $request)
    {
        return ModelStatus::where('desc', 'like', '%' . $request->search . '%')
            ->orWhere('name', 'like', '%' . $request->search . '%')->orderBy('id', 'DESC')->paginate(10);
    }
    /**
     * Create the Package for dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $models=Models::all();
        return view('saas.modelstatus.create',compact('models'));
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
            'name' => 'required|unique:model_status,name,NULL,id,deleted_at,NULL',
            'model_id' => 'required|exists:models,id'

        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $data=[
            'name' => $request->name,
            'desc' => $request->desc,
            'model_id' => $request->model_id

        ];

        $insert=$this->repo->create($data);
        return redirect()->route('modelstatus.index')->with('success',__('app.saas.modelstatus.success_message'));

    }

    /**
     * update the Permission for dashboard.
     *
     * @param Permission $permission
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $models=Models::all();
        $item = $this->repo->findOrFail($id);
        return view('saas.modelstatus.edit',compact('id','item','models'));

    }

    /**
     * Update a resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:model_status,name,'.$id.',id,deleted_at,NULL',
            'model_id' => 'required|exists:models,id'

        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $data=[
            'name' => $request->name,
            'desc' => $request->desc,
            'model_id' => $request->model_id

        ];

        $insert=$this->repo->update($data,$id);
        return redirect()->route('modelstatus.index')->with('success',__('app.saas.modelstatus.success_message'));

    }
    /**
     * Delete more than one permission.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

            return $this->repo->delete($request->id);

    }


}
