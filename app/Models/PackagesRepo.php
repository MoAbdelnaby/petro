<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\PackagesRepoInterface;
use App\Models\Package;
use App\Models\PackageItems;
use App\Models\PackageUserLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;


class PackagesRepo extends AbstractRepo implements PackagesRepoInterface
{
    public function __construct()
    {
        parent::__construct(Package::class);
    }

    public function getItems($packageid)
    {
        return PackageItems::with('model')->where('package_id', $packageid)->orderBy('id', 'DESC')->paginate(10);
    }


    public function getassignedusers($packageid)
    {
        return PackageUserLog::with('user')->where('package_id', $packageid)->orderBy('id', 'DESC')->paginate(10);
    }
}
