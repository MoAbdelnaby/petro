<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageUserLog extends Model
{
    use SoftDeletes;
    protected $table = 'package_user_logs';
    protected $fillable = [
        'package_id',
        'user_package_id',
        'user_id',
        'active',

    ];
    protected $hidden = [

    ];
    protected $casts = [

    ];






    public function package()
    {

        return $this->belongsTo('App\Models\Package', 'package_id');
    }
    public function user()
    {

        return $this->belongsTo('App\User', 'user_id');
    }
    public function userpackage()
    {

        return $this->belongsTo('App\Models\UserPackages', 'user_package_id');
    }
}
