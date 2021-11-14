<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\PermissionsRepoInterface;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Spatie\Permission\Models\Role;


class PermissionsRepo extends AbstractRepo implements PermissionsRepoInterface
{
    public function __construct()
    {
        parent::__construct(Permission::class);
    }


}
