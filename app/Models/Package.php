<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;
    protected $table = 'packages';
    protected $fillable = [
        'name',
        'desc',
        'active',
        'price_monthly',
        'price_yearly',
        'start_date',
        'end_date',
        'type',
        'user_id',
        'is_used',
        'is_offer'
    ];
    protected $hidden = [

       ];
    protected $casts = [

    ];
    public function user()
    {

        return $this->belongsTo('App\User', 'user_id');
    }
}
