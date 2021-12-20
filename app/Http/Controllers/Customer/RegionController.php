<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\RegionRepo;
use App\Models\Branch;
use App\Models\Region;
use App\Models\UserPackages;
use App\Notifications\regionNotification;
use App\User;
use App\userSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use mysql_xdevapi\Exception;
use Validator;

class RegionController extends Controller
{
    protected $repo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RegionRepo $repo)
    {
//        $this->middleware('permission:list-regions|edit-CustomerBranches|delete-CustomerBranches|create-CustomerBranches', ['only' => ['index','store']]);
//        $this->middleware('permission:create-regions', ['only' => ['create','store']]);
//        $this->middleware('permission:edit-regions', ['only' => ['edit','update']]);
//        $this->middleware('permission:delete-regions', ['only' => ['destroy','delete_all']]);
        $this->repo = $repo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index()
    {
//        $items=$this->repo->getactiveRegions();
        $items=$this->repo->getAll();
        $trashs = Region::onlyTrashed()->where('user_id', parentID())->get();
        if (Auth::check())
        {
            $userSettings = UserSetting::where('user_id', Auth::user()->id)->first();
        }
        return view('customer.regions.index',compact('items','userSettings','trashs'));
    }


    /**
     * Create the Package for dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('customer.regions.create');
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
            'name' => 'required|string|min:2|max:60|regex:/^[a-zA-Z ]+$/|unique:regions,name,NULL,id,deleted_at,NULL,user_id,'.auth()->id(),
            'photo' => 'nullable|image',

        ]);

        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $data = Arr::except($validator->validated(), ['photo']);
        if($request->has('photo') && array_key_exists('photo' , $validator->validated())){
            $image = $request->file('photo');
            $fileName = time() . rand(0, 999999999) . '.' . $image->getClientOriginalExtension();
            $request->photo->storeAs('regions',$fileName,'public');
            $data = array_merge($data, ['photo' => 'regions/'.$fileName]);
        }
        $params = array_merge($data, ['user_id' => auth()->user()->id,'display_name'=>$data['name'] ?? '']);
        $insert = $this->repo->create($params);
        if ($insert)
            /* Region notification to admins */
            foreach (User::where('type','admin')->get() as $user) {
                $user->notify( new regionNotification($insert, Auth::user()->name));
            }
        return redirect()->route('customerRegions.index')->with('success',__('app.customers.regions.success_message'));
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
        return view('customer.regions.edit',compact('id','item'));

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
            'name' => 'required|string|min:2|max:60|regex:/^[a-zA-Z ]+$/|unique:branches,name,'.$id.',id,deleted_at,NULL,user_id,'.auth()->id(),
            'photo' => 'nullable|image'
        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $data = Arr::except($validator->validated(), ['photo']);

        if($request->has('photo') && array_key_exists('photo' , $validator->validated())){
            $region = Region::findOrFail($id);
            Storage::disk('public')->delete($region->photo);
            $image = $request->file('photo');
            $fileName = time() . rand(0, 999999999) . '.' . $image->getClientOriginalExtension();
            $request->photo->storeAs('regions',$fileName,'public');
            $data = array_merge($data, ['photo' => 'regions/'.$fileName]);
        }
        $params = array_merge($data, ['user_id' => auth()->user()->id]);

        $insert=$this->repo->update($params,$id);
        return redirect()->route('customerRegions.index')->with('success',__('app.customers.regions.success_message'));

    }
    /**
     * Delete more than one permission.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        try{
            $reagoin = $this->repo->findOrFail($request->id);
            $reagoin->delete($request->id);
            $reagoin->branches()->delete();
            return response()->json(['message' => __('app.success_delete_message'),'alertmsg'=>__('app.success')], 200);
        } catch (\Exception $e){
            return response()->json(['message' => __('app.cannotdelete'),'alertmsg'=>__('app.fail')], 500);
        }

    }

    public function restore(Request $request)
    {
        try{
            $allRows = Region::onlyTrashed()->find($request->trashs);
            if($allRows) {
                foreach ($allRows as $row) {
                    $row->restore();
                    $row->branches()->withTrashed()->restore();
                }
            }
            return redirect()->route('customerRegions.index')->with('success',__('app.success_restore_message'));
        } catch (\Exception $e){
            return redirect()->route('customerRegions.index')->with('danger',__('app.cannotrestore'));
        }
    }
    public function forceDelete(Request $request)
    {
        try{
            $allRows = Region::onlyTrashed()->find($request->trashs);
            if($allRows) {
                foreach ($allRows as $row) {
                    $row->forceDelete();
                    $row->branches()->forceDelete();
                }
            }
            return redirect()->route('customerRegions.index')->with('success',__('app.success_delete_message'));
        } catch (\Exception $e){
            return redirect()->route('customerRegions.index')->with('danger',__('app.cannotdelete'));
        }
    }

//    change active
    public function changeActive($id)
    {

        $item = $this->repo->findOrFail($id);
        $item->active = !$item->active;
        $item->save();
        return redirect()->back();

    }

}
