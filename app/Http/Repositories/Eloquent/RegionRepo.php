<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\RegionRepoInterface;
use App\Models\Region;

class RegionRepo extends AbstractRepo implements RegionRepoInterface
{
    public function __construct()
    {
        parent::__construct(Region::class);
    }

    public function getactiveRegions()
    {
        return $this->model->where('user_id', parentID())->where('active', true)->get();
    }
}
