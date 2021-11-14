<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\ModelfeaturesRepoInterface;
use App\Models\ModelFeature;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;


class ModelfeaturesRepo extends AbstractRepo implements ModelfeaturesRepoInterface
{
    public function __construct()
    {
        parent::__construct(ModelFeature::class);
    }


}
