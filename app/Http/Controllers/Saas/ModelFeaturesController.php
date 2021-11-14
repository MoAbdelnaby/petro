<?php

namespace App\Http\Controllers\Saas;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\ModelfeaturesRepo;
use App\Models\Models;
use Illuminate\Http\Request;
use Validator;
use App\Models\ModelStatus;
use App\Models\Feature;
use App\User;
class ModelFeaturesController extends Controller
{
    protected $repo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ModelfeaturesRepo $repo)
    {
        $this->middleware('permission:list-modelfeatures|edit-modelfeatures|delete-modelfeatures|create-modelfeatures', ['only' => ['index','store']]);
        $this->middleware('permission:create-modelfeatures', ['only' => ['create','store']]);
        $this->middleware('permission:edit-modelfeatures', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-modelfeatures', ['only' => ['destroy','delete_all']]);
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
        return view('saas.modelfeatures.index',compact('items'));
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
        $features=Feature::all();
        return view('saas.modelfeatures.create',compact('models','features'));
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
            'model_id' => 'required|exists:models,id',
            'feature_id' => 'required|exists:features,id',
            'price' => 'required|numeric'

        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $data=[
            'price' => $request->price,
            'feature_id' => $request->feature_id,
            'model_id' => $request->model_id

        ];

        $insert=$this->repo->create($data);
        return redirect()->route('modelfeatures.index')->with('success',__('app.saas.modelfeatures.success_message'));

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
        $features=Feature::all();
        $item = $this->repo->findOrFail($id);
        return view('saas.modelfeatures.edit',compact('id','item','models','features'));

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
            'model_id' => 'required|exists:models,id',
            'feature_id' => 'required|exists:features,id',
            'price' => 'required|numeric'

        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $data=[
            'price' => $request->price,
            'feature_id' => $request->feature_id,
            'model_id' => $request->model_id

        ];

        $insert=$this->repo->update($data,$id);
        return redirect()->route('modelfeatures.index')->with('success',__('app.saas.modelfeatures.success_message'));

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
