<?php

namespace App\Http\Controllers\Saas;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\PackageRequestsRepo;
use App\Models\LtModels;
use App\Models\Package;
use App\Models\PackageItems;
use App\Models\PackageRequest;
use App\Models\PackageUserLog;
use App\Models\UserModel;
use App\Models\UserPackages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
class PackageRequestsController extends Controller
{
    protected $repo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PackageRequestsRepo $repo)
    {
//        $this->middleware('permission:list-packageRequests|edit-packageRequests|delete-packageRequests|create-packageRequests', ['only' => ['index','store']]);
//        $this->middleware('permission:create-packageRequests', ['only' => ['create','store']]);
//        $this->middleware('permission:edit-packageRequests', ['only' => ['edit','update']]);
//        $this->middleware('permission:delete-packageRequests', ['only' => ['destroy','delete_all']]);
        $this->repo = $repo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $items=$this->repo->getWhere([["status","reviewing"]]);

        return view('saas.packageRequests.index',compact('items'));
    }






    /**
     * update the Permission for dashboard.
     *
     * @param Permission $permission
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $item = $this->repo->findOrFail($id);
        return view('saas.packageRequests.show',compact('id','item'));

    }

    /**
     * Delete more than one permission.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
           $item = $this->repo->findOrFail($request->id);
            $item->update([
                "status"=>"refused"
            ]);
           return $this->repo->delete($request->id);

    }
    public function assignUser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'request_id' => 'required|exists:package_requests,id',
            'user_id' => 'required|exists:users,id',
            'package_id' => 'required|exists:packages,id',
            'start_date' => 'required|date|date_format:Y-m-d|before:end_date',
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date',

        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->with("danger",$validator->errors());
        }
        $package=Package::find($request->package_id);
        if($package->end_date < $request->start_date){
            return redirect()->back()->with(['danger','please select start date before package end date'])->withInput();
        }
        if($package->start_date > $request->start_date){
            return redirect()->back()->withErrors(['danger','please select start date after package start date'])->withInput();
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
        $items = PackageItems::with('model')->where('package_id', $package->id)->get();
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
        $packagerequest = $this->repo->findOrFail($request->request_id);
        $packagerequest->update([
            "status"=>"accepted"
        ]);
         $this->repo->delete($request->request_id);
        return redirect()->route('packageRequests.index')->with('success','User Assigned Successfully');

    }
    public function itemsdelete(Request $request)

    {
        $row = PackageRequest::withTrashed()->find($request->id);
        if($row){

            if ($row->trashed()){
                $row->update([
                    "active" =>0
                ]);
//                $row->forceDelete();
            }else{

                $row->delete();

            }
            return 1;

        }else{
            return __('app.saas.packages.cannotdeletenotfound');
        }

    }
}
