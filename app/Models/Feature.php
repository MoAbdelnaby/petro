<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use SoftDeletes;
    protected $table = 'features';
    protected $fillable = [
        'name',
        'price',
        'active'
    ];
    protected $hidden = [

       ];
    protected $casts = [
       
    ];

  

   

    
    public function user()
    {
        
        return $this->belongsTo('App\User', 'user_id');
    }
    public function models()
    {
        
        return $this->hasMany('App\Models\UserModel', 'branch_id', 'id');
    }
    
   


    
}
