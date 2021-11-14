<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchFiles extends Model
{
    protected $fillable = [
        'name',
        'size',
        'start',
        'end',
        'type',
        'url',
        'status',
        'user_model_branch_id',
        'branch_id',
        'model_type',
        'user_id',
    ];

    public function branch()
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

}
