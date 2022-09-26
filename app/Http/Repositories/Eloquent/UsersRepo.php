<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\UsersRepoInterface;
use App\User;

class UsersRepo extends AbstractRepo implements UsersRepoInterface
{
    public function __construct()
    {
        parent::__construct(User::class);
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function getRelative($user_id)
    {
        return $this->model->with('branches', 'position')
            ->where('parent_id', $user_id)
            ->whereIn('type', ['subcustomer', 'subadmin'])
            ->where('wakeb_user',0)
            ->latest()
            ->get();
    }
}
