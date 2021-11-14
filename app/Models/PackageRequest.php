<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageRequest extends Model
{
    use SoftDeletes;
    protected $table = 'package_requests';
    protected $fillable = [
        'user_id',
        'package_id',
        'status',
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
    public function package()
    {

        return $this->belongsTo('App\Models\Package', 'package_id');
    }
}
