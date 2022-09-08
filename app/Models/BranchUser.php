<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchUser extends Model
{
    protected $table = 'branches_users';

    protected $guarded = [];

    public function branch()
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }
}
