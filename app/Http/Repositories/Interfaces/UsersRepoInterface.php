<?php

namespace App\Http\Repositories\Interfaces;

use App\Http\Requests\UsersStoreRequest;
use App\Http\Requests\UsersUpdateRequest;

interface UsersRepoInterface
{
    public function getRelative($user_id);
}
