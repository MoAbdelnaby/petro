<?php

namespace App\Http\Repositories\Interfaces;

use App\Http\Requests\AuthLoginRequest;

interface AuthRepoInterface
{
    public function login(AuthLoginRequest $request);

    public function logout($request);

    public function currentUser($request);
}
