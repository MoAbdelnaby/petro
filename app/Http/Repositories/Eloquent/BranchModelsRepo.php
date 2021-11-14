<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\BranchModelsRepoInterface;
use App\Models\Branch;
use App\Models\UserModel;
use App\Models\UserModelBranch;
use App\Models\UserPackages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;


class BranchModelsRepo extends AbstractRepo implements BranchModelsRepoInterface
{
    public function __construct()
    {
        parent::__construct(UserModelBranch::class);
    }


    public function getactiveBranches()
    {
        return Branch::where('user_id', parentID())->where('active', '1')->get();
    }


    public function getactiveModels()
    {
        $package = UserPackages::where('user_id', parentID())->where('active', '1')->first();
        return UserModel::with('model')->with('package')->where('user_package_id', $package->id)->get();
    }

    public function getActiveUserModels()
    {

//        $package=UserPackages::where('user_id', parentID()->where('active', '1')->first();
//        return  UserModel::with('model')->with('package')->where('user_package_id', $packageid)->orderBy('id', 'DESC')->paginate(10);
    }

}
