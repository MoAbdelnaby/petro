<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelsChart extends Model
{
    use SoftDeletes;
    protected $table = 'models_charts';
    protected $fillable = [
        'name',
        'photo',
        'active',
        'model_id'

    ];
    protected $hidden = [

    ];
    protected $casts = [

    ];

    public function setting()
    {

        return $this->belongsTo('App\Models\Models', 'model_id');
    }
}
