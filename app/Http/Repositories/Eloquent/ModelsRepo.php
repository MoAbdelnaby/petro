<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\ModelsRepoInterface;
use App\Models\Models;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;


class ModelsRepo extends AbstractRepo implements ModelsRepoInterface
{
    public function __construct()
    {
        parent::__construct(Models::class);
    }


}
