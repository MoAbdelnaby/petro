<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\UsersRepoInterface;
use App\Http\Requests\UsersStoreRequest;
use App\Http\Requests\UsersUpdateRequest;
use App\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class UsersRepo extends AbstractRepo implements UsersRepoInterface
{
    public function __construct()
    {
        parent::__construct(User::class);
    }


    public function getRelative($user_id)
    {
        return $this->model::with('branches')
            ->where('parent_id', $user_id)
            ->whereIn('type',['subcustomer','subadmin'])
            ->orderBy('id', 'DESC')
            ->paginate(10);
    }
}
