<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{

    protected $table = 'user_settings';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
