<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserWatchModels extends Model
{
    use SoftDeletes;
    protected $table = 'user_watch_models';
    protected $fillable = [
        'user_model_branch_id',
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
    public function usermodelbranch()
    {

        return $this->belongsTo('App\Models\UserModelBranch', 'user_model_branch_id');
    }
}
