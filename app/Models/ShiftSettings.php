<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShiftSettings extends Model
{
    use SoftDeletes;
    protected $table = 'shift_settings';
    protected $fillable = [
        'start_time',
        'end_time',
        'start_date',
        'end_date',
        'notification',
        'notification_start',
        'notification_end',
        'screenshot',
        'user_model_id',
        'active'
    ];
    protected $hidden = [

       ];
    protected $casts = [
       
    ];

  

   

   
    public function user_model()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_model_id');
    }
    
   


    
}
