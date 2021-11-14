<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserModel extends Model
{
    use SoftDeletes;

    protected $table = 'users_models';

    protected $fillable = [
        'model_id', 'user_id', 'active'
    ];

    public function model()
    {
        return $this->belongsTo('App\Models\Models', 'model_id');
    }

    public function package()
    {
        return $this->belongsTo('App\Models\UserPackages', 'user_package_id');
    }

    public function branches()
    {
        return $this->hasMany(UserModelBranch::class);
    }

}
