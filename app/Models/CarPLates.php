<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarPLates extends Model
{
    use SoftDeletes;
    protected $table = 'car_plates';
    protected $fillable = [
        'user_model_branch_id',
        'area',
        'plate_no',
        'date',
        'time',
        'camera_id',
        'screenshot',
        'setting_id',
        'active'
    ];
    protected $hidden = [

    ];
    protected $casts = [

    ];






    public function usermodelbranch()
    {

        return $this->belongsTo('App\Models\UserModelBranch', 'user_model_branch_id');
    }
    public function setting()
    {

        return $this->belongsTo('App\Models\CarPlatesSetting', 'setting_id');
    }
}
