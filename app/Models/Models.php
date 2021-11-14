<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Models extends Model
{
    use SoftDeletes;
    protected $table = 'models';
    protected $fillable = [
        'name',
        'description',
        'active',
        'user_id'
    ];
    protected $hidden = [

       ];
    protected $casts = [

    ];
    public function user()
    {

        return $this->belongsTo('App\User', 'user_id');
    }
    public function model()
    {

        return $this->belongsTo('App\Models\LtModels', 'lt_model_id');
    }

}
