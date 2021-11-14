<?php

namespace App\Http\Controllers\Saas;
use App\Http\Controllers\Controller;
use App\Models\LtModels;
use Illuminate\Http\Request;
use Validator;
use App\Models\Models;
use App\User;
use App\Http\Repositories\Eloquent\ModelsRepo;
class ModelsController extends Controller
{
    protected $repo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ModelsRepo $repo)
    {
        $this->middleware('permission:list-models|edit-models|delete-models|create-models', ['only' => ['index','store']]);
        $this->middleware('permission:create-models', ['only' => ['create','store']]);
        $this->middleware('permission:edit-models', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-models', ['only' => ['destroy','delete_all']]);
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

        return view('saas.models.index',compact('items'));
    }

    public function search(Request $request)
    {
        return Models::with('model')->where('description', 'like', '%' . $request->search . '%')
            ->orWhere('price', 'like', '%' . $request->search . '%')
            ->orWhere('name', 'like', '%' . $request->search . '%')->orderBy('id', 'DESC')->paginate(10);
    }
    /**
     * Create the Package for dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $models=LtModels::all();
        return view('saas.models.create',compact('models'));
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
            'name' => 'required|unique:models,name,NULL,id,deleted_at,NULL',
            'lt_model_id' => 'required|exists:lt_models,id',
            'price' => 'required|numeric',

        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $data=[
            'name' => $request->name,
            'description' => $request->description,
            'lt_model_id' => $request->lt_model_id,
            'price' => $request->price,
            'user_id' => auth()->user()->id,
        ];

        $insert=$this->repo->create($data);
        return redirect()->route('models.index')->with('success',__('app.saas.models.success_message'));

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
        $models=LtModels::all();
        return view('saas.models.edit',compact('id','item','models'));

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
            'name' => 'required|unique:models,name,'.$id.',id,deleted_at,NULL',
            'lt_model_id' => 'required|exists:lt_models,id',
            'price' => 'required|numeric',

        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $data=[
            'name' => $request->name,
            'description' => $request->description,
            'lt_model_id' => $request->lt_model_id,
            'price' => $request->price,
            'user_id' => auth()->user()->id,

        ];

        $insert=$this->repo->update($data,$id);
        return redirect()->route('models.index')->with('success',__('app.saas.models.success_message'));

    }
    /**
     * Delete more than one permission.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $found=\App\Models\PackageItems::where('model_id', $request->id)->where('active', 1)->first();
        if($found){
            return __('app.saas.models.cannotdeleteused');
        }else{
            return $this->repo->delete($request->id);
        }


    }


}
