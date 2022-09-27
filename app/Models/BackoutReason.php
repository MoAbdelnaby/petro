<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BackoutReason extends Model
{


    /**
     * @var string[]
     */
    protected $fillable = [
        'station_code',
        'LatestPlateNumber',
        'BayCode',
        'CustomerName',
        'CustomerPhone',
        'make',
        'model',
        'reason1',
        'reason2',
        'reason3',
        'car_profile_id',
    ];

    public function carprofile()
    {
        return $this->belongsTo(Carprofile::class,'car_profile_id');
    }

}
