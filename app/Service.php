<?php

namespace App;

use App\Models\Branch;
use App\Models\BranchService;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $guarded = [];

    public function branches()
    {
        return $this->belongsToMany(Branch::class, BranchService::class, 'service_id', 'branch_id');
    }
}