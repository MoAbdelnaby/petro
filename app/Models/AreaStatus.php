<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaStatus extends Model
{
    protected $fillable = [
        'status',
        'area',
        'branch_id',
        'last_plate'
    ];
}
