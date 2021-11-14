<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\FeaturesRepoInterface;
use App\Models\Feature;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;


class FeaturesRepo extends AbstractRepo implements FeaturesRepoInterface
{
    public function __construct()
    {
        parent::__construct(Feature::class);
    }


}
