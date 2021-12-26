<?php

namespace App\Http\Controllers\Customer;

use App\BranchNetWork;
use App\BranchStatus;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\BranchModelsRepo;
use App\Models\Branch;
use App\Models\Permission;
use App\Models\Role;
use App\Models\UserModel;
use App\Models\UserModelBranch;
use App\Models\UserPackages;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class BranchModelsController extends Controller
{
    protected $repo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BranchModelsRepo $repo)
    {
        $this->middleware('permission:list-branchmodels|edit-branchmodels|delete-branchmodels|create-branchmodels', ['only' => ['index', 'store']]);
        $this->middleware('permission:create-branchmodels', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-branchmodels', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-branchmodels', ['only' => ['destroy', 'delete_all']]);
        $this->repo = $repo;
    }

    /**
     * \Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $activepackage = UserPackages::where('user_id', parentID())->where('active', '1')->first();

        $items = DB::table('user_model_branches')
            ->select(['user_model_branches.*', 'branches.name as bname', 'models.name as mname'])
            ->join('users_models', 'users_models.id', '=', 'user_model_branches.user_model_id')
            ->join('branches', 'branches.id', '=', 'user_model_branches.branch_id')
            ->join('models', 'models.id', '=', 'users_models.model_id')
            ->where('users_models.user_package_id', $activepackage->id)
            ->orderBy('id', 'DESC')->paginate(10);

        return view('customer.branchmodels.index', compact('items'));
    }

    public function show($id)
    {

        $item = UserModelBranch::where('user_model_id', $id)->whereHas('branch', function ($q) {
            return $q->where('active', true);
        })->first();

        if (is_null($item)) return redirect()->back()->with('danger', __('app.gym.empty_branch'));

        $modelType = $item->usermodel->model->model->id;

        if ($modelType == 1) {
            return redirect()->route('door.index', [$item->id]);
        } else if ($modelType == 2) {
            return redirect()->route('recieption.index', [$item->id]);
        } else if ($modelType == 3) {
            return redirect()->route('people.index', [$item->id]);
        } else if ($modelType == 4) {
            return redirect()->route('car.index', [$item->id]);
        } else if ($modelType == 5) {
            return redirect()->route('emotion.index', [$item->id]);
        } else if ($modelType == 6) {
            return redirect()->route('mask.index', [$item->id]);
        } else if ($modelType == 7) {
            return redirect()->route('heatmap.index', [$item->id]);
        } else if ($modelType == 8) {
            return redirect()->route('places.index', [$item->id]);
        } else if ($modelType == 9) {
            return redirect()->route('plates.index', [$item->id]);
        } else {
            return redirect()->route('branchmodels.index')->with('danger', __('app.customers.branchmodels.modelnotexist'));
        }

    }

    public function preview($id)
    {
        $item = $this->repo->findOrFail($id);

        $modelType = $item->usermodel->model->model->id;

        if ($modelType == 1) {
            return redirect()->route('door.index', [$item->id]);
        } else if ($modelType == 2) {
            return redirect()->route('recieption.index', [$item->id]);
        } else if ($modelType == 3) {
            return redirect()->route('people.index', [$item->id]);
        } else if ($modelType == 4) {
            return redirect()->route('car.index', [$item->id]);
        } else if ($modelType == 5) {
            return redirect()->route('emotion.index', [$item->id]);
        } else if ($modelType == 6) {
            return redirect()->route('mask.index', [$item->id]);
        } else if ($modelType == 7) {
            return redirect()->route('heatmap.index', [$item->id]);
        } else if ($modelType == 8) {
            return redirect()->route('places.index', [$item->id]);
        } else if ($modelType == 9) {
            return redirect()->route('plates.index', [$item->id]);
        } else {
            return redirect()->route('branchmodels.index')->with('danger', __('app.customers.branchmodels.modelnotexist'));
        }

    }

    /**
     * Create the Package for dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $branches = $this->repo->getactiveBranches();
        $models = $this->repo->getactiveModels();
        return view('customer.branchmodels.create', compact('branches', 'models'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_model_id' => 'required|exists:users_models,id',
            'branch_id' => 'required|array|min:1',
            'branch_id.*' => 'required|exists:branches,id',
        ], [
            'branch_id' => 'Branch Field is required',
            'branch_id.*' => 'Branch Field is required',
        ]);

        if ($validator->errors()->count()) {
            return redirect()->back()->with([
                'danger' => $validator->errors()->first()
            ]);
        }
        $userModel = UserModel::where('id', $request->user_model_id)->with('branches')->first();
        $modelcount = UserModelBranch::where('user_model_id', $request->user_model_id)->count();
        if ($modelcount >= $userModel->count) {
            return redirect()->route('customerPackages.index')->with('danger', __('app.customers.branchmodels.reach_limit'));
        }

        $allbranch_ids = UserModelBranch::where('user_model_id', $request->user_model_id)->pluck('branch_id')->toArray();

        $diffCreate = array_values(array_diff($request->branch_id, $allbranch_ids));
        $diffDelete = array_values(array_diff($allbranch_ids, $request->branch_id));

        if (!empty($diffCreate)) {
            foreach ($diffCreate as $branch_id) {

                $oldBranch = UserModelBranch::where([
                    'user_model_id' => $request->user_model_id,
                    'branch_id' => $branch_id,
                ])->withTrashed()->first();

                !$oldBranch ? UserModelBranch::create([
                    'user_model_id' => $request->user_model_id,
                    'branch_id' => $branch_id
                ]) : $oldBranch->restore();
            }
        }

        if (!empty($diffDelete)) {
            foreach ($diffDelete as $branch_id) {
                UserModelBranch::where('user_model_id', $request->user_model_id)->where('branch_id', $branch_id)->delete();
            }
        }

        return redirect()->route('customerPackages.index')->with('success', __('app.customers.branchmodels.success_message'));

    }

    /**
     * update the Permission for dashboard.
     *
     * @param Permission $permission
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $branches = $this->repo->getactiveBranches();
        $models = $this->repo->getactiveModels();
        $item = $this->repo->findOrFail($id);
        return view('customer.branchmodels.edit', compact('id', 'item', 'branches', 'models'));

    }

    /**
     * Update a resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_model_id' => 'required|exists:users_models,id',
            'branch_id' => 'required|exists:branches,id',

        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $exists = UserModelBranch::where('id', '!=', $id)->where('user_model_id', $request->user_model_id)->where('branch_id', $request->branch_id)->first();
        if ($exists) {
            return redirect()->route('branchmodels.index')->with('danger', __('app.customers.branchmodels.duplicate_message'));
        }
        $userModel = UserModel::find($request->user_model_id);
        $modelcount = UserModelBranch::where('id', '!=', $id)->where('user_model_id', $request->user_model_id)->count();
        if ($modelcount >= $userModel->count) {
            return redirect()->route('branchmodels.index')->with('danger', __('app.customers.branchmodels.reach_limit'));
        }
        $data = [
            'user_model_id' => $request->user_model_id,
            'branch_id' => $request->branch_id,
        ];

        $insert = $this->repo->update($data, $id);
        return redirect()->route('branchmodels.index')->with('success', __('app.customers.branchmodels.success_message'));

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

    public function BranchesStatus()
    {
        /* get branches by table view last_branch_error */
        $branches = BranchStatus::orderBy('id', 'DESC')->distinct('branch_code')->with('branch')->get();
        $off = BranchStatus::orderBy('id', 'DESC')->distinct('branch_code')
            ->where('created_at', '<', Carbon::now()->subMinutes(15))
            ->count();
        $on = BranchStatus::orderBy('id', 'DESC')->distinct('branch_code')
            ->where('created_at', '>=', Carbon::now()->subMinutes(15))
            ->where('created_at', '<=', Carbon::now())
            ->count();
        return view("customer.branches_status.index", compact('branches', 'off', 'on'));
    }

    public function getLogs($code) {
        $logChart = array();
        $branchName = Branch::where('code',$code)->first()->name;
        $logs = BranchNetWork::with('user')->where("branch_code","=",$code)->paginate(25);
        foreach (BranchNetWork::where('branch_code','=',$code)->get() as $key => $bStatus) {
            $logChart[$key]['created_at'] = $bStatus->created_at->format("Y-m-d h:i a");
            $logChart[$key]['status'] = ($bStatus->status == 'online') ? 1 : 0;
        }
//        return response()->json($logChart);
        return view("customer.branches_status.logs",compact('logs','branchName','logChart'));
    }

}
