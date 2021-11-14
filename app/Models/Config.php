<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = [
        'key',
        'value',
        'view',
        'model_type',
        'user_id',
        'active'
    ];

}
