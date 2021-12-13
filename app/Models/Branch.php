<?php

namespace App\Models;

use App\Services\SeederCheck;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;

    protected $table = 'branches';
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'branches_users');
    }

    protected $hidden = [

    ];

    protected static function booted()
    {
        static::updated(function ($region) {
            if (!SeederCheck::isRunning()) {
                $changes = $region->isDirty() ? $region->getDirty() : false;
                if ($changes) {
                    unset($changes['updated_at']);
                    activity()
                        ->performedOn($region)
                        ->inLog('branch')
                        ->causedBy(auth()->user())
                        ->withProperties($changes)
                        ->log(auth()->user()->name . ' Updated- ' . $region->name);

                }
            }
        });

        static::created(function ($region) {
            if (!SeederCheck::isRunning()) {
                $changes = $region->getDirty();
                if ($changes) {
                    unset($changes['id'], $changes['created_at'], $changes['updated_at'], $changes['user_id']);
                    activity()
                        ->causedBy(auth()->user())
                        ->inLog('branch')
                        ->performedOn($region)
                        ->withProperties($changes)
                        ->log(auth()->user()->name . ' Created - ' . $region->name);
                }
            }
        });

    }

//    protected static $logAttributes = ['name', 'photo', 'description','active','code', 'area_count','region_id'];
    //    protected static $submitEmptyLogs = false;
    //    protected static $logOnlyDirty = true;
    //    protected static $logName = 'branch';

//    public function  getDescriptionForEvent(string $eventName): string
    //    {
    //        return "you Have {$eventName} branch";
    //    }

    public function user()
    {

        return $this->belongsTo('App\User', 'user_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function areas()
    {
        return $this->hasMany(AreaStatus::class);
    }

    public function models()
    {

        return $this->hasMany('App\Models\UserModel', 'branch_id', 'id');
    }

    public function modelsBranches()
    {

        return $this->hasMany('App\Models\UserModelBranch', 'branch_id', 'id');
    }

    public function speedLogs()
    {
        return $this->hasMany(ConnectionSpeed::class);
    }

    public function services()
    {
        return $this->belongsToMany('App\Service', 'branch_services', 'branch_id', 'service_id');
    }
}