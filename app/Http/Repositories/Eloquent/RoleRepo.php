<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\RoleRepoInterface;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Spatie\Permission\Models\Role;
use App\Role as AppRole;
class RoleRepo extends AbstractRepo implements RoleRepoInterface
{
    public function __construct()
    {
        parent::__construct(AppRole::class);
    }


}
