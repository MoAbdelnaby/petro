<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelFeature extends Model
{
    use SoftDeletes;
    protected $table = 'model_features';
    protected $fillable = [
        'model_id',
        'feature_id',
        'price',
        'active'
    ];
    protected $hidden = [

       ];
    protected $casts = [

    ];





    public function model()
    {

        return $this->belongsTo('App\Models\LtModels', 'model_id');
    }
    public function feature()
    {

        return $this->belongsTo('App\Models\Feature', 'feature_id');
    }






}
