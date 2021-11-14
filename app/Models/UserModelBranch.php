<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserModelBranch extends Model
{
    use SoftDeletes;

    protected $table = 'user_model_branches';

    protected $fillable = ['user_model_id', 'branch_id', 'active'];

    protected $hidden = [];

    protected $casts = [];

    public function usermodel()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_model_id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch', 'branch_id');
    }

    public function areaDuration()
    {
        return $this->hasMany(AreaDuration::class);
    }
}
