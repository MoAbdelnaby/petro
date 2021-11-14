<?php

namespace App\Http\Controllers\Saas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Spatie\Permission\Models\Permission;
use App\Http\Repositories\Eloquent\FeaturesRepo;
use App\Models\Feature;

class FeatureController extends Controller
{
    protected $repo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FeaturesRepo $repo)
    {
        $this->middleware('permission:list-features|edit-features|delete-features|create-features', ['only' => ['index','store']]);
        $this->middleware('permission:create-features', ['only' => ['create','store']]);
        $this->middleware('permission:edit-features', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-features', ['only' => ['destroy','delete_all']]);
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
        return view('saas.features.index',compact('items'));
    }

    public function search(Request $request)
    {
        return Feature::where('price', 'like', '%' . $request->search . '%')
            ->orWhere('name', 'like', '%' . $request->search . '%')->orderBy('id', 'DESC')->paginate(10);
    }
    /**
     * Create the Package for dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('saas.features.create');
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
                    'name' => 'required|unique:features,name,NULL,id,deleted_at,NULL',
                    'price' => 'required',

                ]);
                if ($validator->errors()->count()) {
                    return redirect()->back()->withErrors($validator->errors())->withInput();
                }
                $data=[
                    'name' => $request->name,
                    'price' => $request->price,

                ];

            $insert=$this->repo->create($data);
            return redirect()->route('features.index')->with('success',__('app.saas.features.success_message'));

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
        return view('saas.features.edit',compact('id','item'));

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
            'name' => 'required|unique:features,name,'.$id.',id,deleted_at,NULL',
            'price' => 'required',

        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $data=[
            'name' => $request->name,
            'price' => $request->price,

        ];

        $insert=$this->repo->update($data,$id);
        return redirect()->route('features.index')->with('success',__('app.saas.features.success_message'));

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
