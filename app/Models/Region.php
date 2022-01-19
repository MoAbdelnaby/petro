<?php

namespace App\Models;

use App\Services\SeederCheck;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function parent()
    {
        return $this->hasOne(__CLASS__, 'id', 'parent_id');
    }

    public function getFullPhotoAttribute()
    {
        $photo = $this->photo ?? '';
        if ($this->parent != null) {
            $photo = $this->parent->photo;
        }
        return $photo;
    }

    protected static function booted()
    {

        static::updated(function ($region) {
            if (!SeederCheck::isRunning()) {

                if ($region) {
                    $changes = $region->isDirty() ? $region->getDirty() : false;
                    if ($changes) {
                        unset($changes['updated_at']);
                        activity()
                            ->performedOn($region)
                            ->inLog('region')
                            ->causedBy(auth()->user())
                            ->withProperties($changes)
                            ->log(auth()->user()->name . ' Updated- ' . $region->name);

                    }
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
                        ->inLog('region')
                        ->performedOn($region)
                        ->withProperties($changes)
                        ->log(auth()->user()->name . ' Created - ' . $region->name);
                }
            }
        });

    }


}
