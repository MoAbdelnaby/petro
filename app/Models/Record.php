<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Record extends Model
{
    use SoftDeletes;
    protected $table = 'records';
    protected $fillable = [
        'date',
        'time',
        'screenshot',
        'shift_setting_id',
        'note',
        'active',
        'user_model_id',
        'model_status_id'
    ];
    protected $hidden = [

       ];
    protected $casts = [
       
    ];

  

   

    public function model_status()
    {
        return $this->belongsTo('App\Models\ModelStatus', 'model_status_id');
    }
    public function user_model()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_model_id');
    }

    public function shift_setting()
    {
        return $this->belongsTo('App\Models\ShiftSettings', 'shift_setting_id');
    }
    
   


    
}
