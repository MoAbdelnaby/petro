<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded =[];
    public function usermodelbranch()
    {

        return $this->belongsTo('App\Models\UserModelBranch', 'user_model_branch_id');
    }


}
