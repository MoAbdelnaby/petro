<?php

namespace App\Http\Controllers\Saas;
use App\Http\Controllers\Controller;
use App\Models\ModelFeature;
use App\Models\Models;
use App\Models\PackageItems;
use App\Models\PackageUserLog;
use App\Models\UserModel;
use App\Models\UserPackages;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Spatie\Permission\Models\Permission;
use App\Http\Repositories\Eloquent\PackagesRepo;
use App\Models\Package;

class PackageController extends Controller
{
    protected $repo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PackagesRepo $repo)
    {
        $this->middleware('permission:list-packages|edit-packages|delete-packages|create-packages', ['only' => ['index','store']]);
        $this->middleware('permission:create-packages', ['only' => ['create','store']]);
        $this->middleware('permission:edit-packages', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-packages', ['only' => ['destroy','delete_all']]);
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
        return view('saas.packages.index',compact('items'));
    }

    public function search(Request $request)
    {
        return Package::where('type', 'like', '%' . $request->search . '%')
                ->orWhere('desc', 'like', '%' . $request->search . '%')
                ->orWhere('price_monthly', 'like', '%' . $request->search . '%')
                ->orWhere('price_yearly', 'like', '%' . $request->search . '%')
                ->orWhere('name', 'like', '%' . $request->search . '%')->orderBy('id', 'DESC')->paginate(10);
    }
    /**
     * Create the Package for dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('saas.packages.create');
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
                    'name' => 'required|unique:packages,name,NULL,id,deleted_at,NULL',
                    'type' => 'required',
                    'is_offer' => 'required|in:0,1',
                    'price_monthly' => 'exclude_unless:type,monthly|required',
                    'price_yearly' => 'exclude_unless:type,annual|required',
                    'start_date' => 'required|date|date_format:Y-m-d|before:end_date',
                    'end_date' => 'required|date|date_format:Y-m-d|after:start_date',
                ]);
                if ($validator->errors()->count()) {
                    return redirect()->back()->withErrors($validator->errors())->withInput();
                }
                $data=[
                    'name' => $request->name,
                    'desc' => $request->desc,
                    'price_monthly' => $request->price_monthly,
                    'price_yearly' => $request->price_yearly,
                    'type' => $request->type,
                    'is_offer' => $request->is_offer,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'user_id' => auth()->user()->id,
                ];

            $insert=$this->repo->create($data);
            return redirect()->route('packages.index')->with('success',__('app.saas.packages.success_message'));

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
        return view('saas.packages.edit',compact('id','item'));

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
            'name' => 'required|unique:packages,name,'.$id.',id,deleted_at,NULL',
            'type' => 'required',
            'is_offer' => 'required|in:0,1',
            'price_monthly' => 'exclude_unless:type,monthly|required',
            'price_yearly' => 'exclude_unless:type,annual|required',
            'start_date' => 'required|date|date_format:Y-m-d|before:end_date',
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date',
        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $data=[
            'name' => $request->name,
            'desc' => $request->desc,
            'price_monthly' => $request->price_monthly,
            'price_yearly' => $request->price_yearly,
            'type' => $request->type,
            'is_offer' => $request->is_offer,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'user_id' => auth()->user()->id,
        ];

        $insert=$this->repo->update($data,$id);
        return redirect()->route('packages.index')->with('success',__('app.saas.packages.success_message'));

    }
    /**
     * Delete more than one permission.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $package=$this->repo->first($request->id);
        if($package){
            if($package->is_used==1){
                return __('app.saas.packages.cannotdeleteused');
            }else{
                 $this->repo->delete($request->id);
                return 1;
            }


        }else{
            return __('app.saas.packages.cannotdeletenotfound');
        }
    }

    public function itemsindex($id)
    {
        $model = $this->repo->findOrFail($id);
        if($model){
            $items = $this->repo->getItems($id);
            $result=[];
            foreach ($items as $item){
                $modelfeatures=json_decode($item->features);
                $featurename=[];
                if($modelfeatures) {
                    foreach ($modelfeatures as $modelfeature) {
                        $modelfeaturerecord = ModelFeature::with('feature')->find($modelfeature);
                        $featurename[] = $modelfeaturerecord->feature->name;
                    }
                }
                $item->featurenames=$featurename;
                $result[]= $item;
            }

            $items=$result;
            return view('saas.packages.items.index',compact('id','items'));
        }else{
            return redirect()->back();
        }


    }

    public function itemsedit($id)
    {
        $item = PackageItems::where('id', $id)->first();
        $models=Models::all();
        $modelFeature=ModelFeature::with('feature')->where('model_id',  $item->model_id )->get();
        return view('saas.packages.items.edit',compact('id','item','models','modelFeature'));

    }

    public function itemscreate($id)
    {
        $models=Models::all();
        return view('saas.packages.items.create',compact('id','models'));
    }

    public function modelfeatures(Request $request)
    {
        $model=Models::find($request->model_id);
        return ModelFeature::with('feature')->where('model_id',  $model->lt_model_id )->get();
    }


    public function itemscreatepost(Request $request,$id)
    {

        $validator = Validator::make($request->all(), [
            'model_id' => 'required|exists:models,id',
            'package_id' => 'required|exists:packages,id',
            'count' => 'required|numeric',

        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $insert = PackageItems::create([
            'model_id' => $request->model_id,
            'package_id' => $request->package_id,
            'count' => $request->count,
            'features' => \GuzzleHttp\json_encode($request->features),
        ]);
        return redirect()->route('packages.items',[$id])->with('success',__('app.saas.packages.success_message'));

    }


    public function itemseditpost(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'model_id' => 'required|exists:models,id',
            'package_id' => 'required|exists:packages,id',
            'count' => 'required|numeric',

        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $insert = PackageItems::where('id', $id)->first();
        $insert->update([
            'model_id' => $request->model_id,
            'package_id' => $request->package_id,
            'count' => $request->count,
            'features' => \GuzzleHttp\json_encode($request->features),
        ]);
        return redirect()->route('packages.items',[$request->package_id])->with('success',__('app.saas.packages.success_message'));

    }
    public function itemsdelete(Request $request)

    {
        $item = PackageItems::where('id', $request->id)->first();
        if($item){

            PackageItems::where('id', $request->id)->delete();
            return 1;

        }else{
            return __('app.saas.packages.cannotdeletenotfound');
        }

    }


    public function assignuser($id)
    {
        $package = $this->repo->findOrFail($id);
        $history=$this->repo->getassignedusers($id);
        if($package){
            $users = User::where('type', 'customer')->get();
            return view('saas.packages.items.assignuser',compact('id','users','history'));
        }else{
            return redirect()->back();
        }


    }


    public function assignuserpost(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'package_id' => 'required|exists:packages,id',
            'start_date' => 'required|date|date_format:Y-m-d|before:end_date',
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date',

        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $package=Package::find($request->package_id);
        if($package->end_date < $request->start_date){
            return redirect()->back()->withErrors(['start_date'=>'please select start date before package end date'])->withInput();
        }
        if($package->start_date > $request->start_date){
            return redirect()->back()->withErrors(['start_date'=>'please select start date after package start date'])->withInput();
        }
        DB::beginTransaction();
        try{
        $curent=UserPackages::where('user_id', $request->user_id)->where('active',1)->first();
        UserPackages::where('user_id', $request->user_id)->where('active',1)->update([
            'active'=>0
        ]);
        if($curent) {
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
            'user_id' => $request->user_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        $items = $this->repo->getItems($package->id);
        foreach ($items as $item){
            $insertitem = UserModel::create([
                'model_id' => $item->model_id,
                'user_package_id' => $insert->id,
                'features' => $item->features,
                'count' => $item->count,
            ]);
        }
        PackageUserLog::create([
            'package_id' => $package->id,
            'user_package_id' => $insert->id,
            'user_id' => $request->user_id,
        ]);
        DB::commit();
        }catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()->with('danger', "UnExpected Error");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('danger', "UnExpected Error");
        }
        return redirect()->route('packages.index')->with('success','User Assigned Successfully');

    }


}
