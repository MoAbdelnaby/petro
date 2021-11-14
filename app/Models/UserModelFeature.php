<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserModelFeature extends Model
{
    use SoftDeletes;
    protected $table = 'user_model_feature';
    protected $fillable = [
        'user_model_id',
        'feature_id',
        'price',
        'start_date',
        'end_date',
        'active'
    ];
    protected $hidden = [

       ];
    protected $casts = [
       
    ];

  

   

    public function usermodel()
    {
        
        return $this->belongsTo('App\Models\UserModel', 'user_model_id');
    }
    public function package()
    {
        
        return $this->belongsTo('App\Models\Feature', 'feature_id');
    }
   
    
   


    
}
