<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarPLatesSetting extends Model
{
    use SoftDeletes;
    protected $table = 'car_plates_settings';
    protected $fillable = [
        'start_time',
        'end_time',
        'start_date',
        'end_date',
        'user_model_branch_id',
        'notification',
        'notification_start',
        'notification_end',
        'screenshot',
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
}
