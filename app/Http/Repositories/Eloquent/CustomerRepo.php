<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\CustomerRepoInterface;
use App\Models\Package;
use App\Models\PackageItems;
use App\Models\PackageRequest;
use App\Models\UserModel;
use App\Models\UserPackages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;


class CustomerRepo extends AbstractRepo implements CustomerRepoInterface
{
    public function __construct()
    {
        parent::__construct(UserPackages::class);
    }


    public function getactivePackage()
    {
        return $this->model::where('user_id', parentID())->where('active', '1')->first();
    }

    public function getOldRequests()
    {
        return PackageRequest::onlyTrashed()->where('user_id', parentID())->get();
    }

    public function getPackagesItems($packageid)
    {
        return UserModel::with(['model', 'model.model','package'])->where('user_package_id', $packageid)->get();
    }

    public function getAllPackages()
    {
        return Package::where('active', '1')->get();
    }

    public function packageDetails($package)
    {
        return PackageItems::with('model')->with('package')->where('package_id', $package)->orderBy('id', 'DESC')->paginate(10);
    }

    public function retrievePackage($packageid)
    {
        return Package::find($packageid);
    }
}
