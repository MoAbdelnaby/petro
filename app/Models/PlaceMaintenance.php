<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaceMaintenance extends Model
{
    use SoftDeletes;
    protected $table = 'place_maintenances';
    protected $fillable = [
        'user_model_branch_id',
        'area',
        'status',
        'date',
        'time',
        'camera_id',
        'screenshot',
        'setting_id',
        'disk',
        'active'
    ];
    protected $hidden = [

    ];
    protected $casts = [

    ];

    protected $appends = ['path_screenshot'];


    function getPathScreenshotAttribute()
    {
        if ($this->disk == 'azure') {
            return config('app.azure_storage').config('app.azure_container')."/storage".$this->screenshot;

        } else {
//            return 'https://petromin-api.wakeb.tech'.'/storage'. $this->screenshot;
            return config('app.local_media_url').'/storage'. $this->screenshot;
        }
    }

    public function usermodelbranch()
    {

        return $this->belongsTo('App\Models\UserModelBranch', 'user_model_branch_id');
    }
    public function setting()
    {

        return $this->belongsTo('App\Models\PlaceMaintenanceSetting', 'setting_id');
    }
}
