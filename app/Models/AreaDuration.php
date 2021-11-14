<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaDuration extends Model
{
    protected $fillable = [
        'work_by_minute',
        'empty_by_minute',
        'area',
        'branch_id',
        'last_id',
    ];
}
