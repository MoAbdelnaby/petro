<?php

namespace App;

use App\Models\Branch;
use App\Models\Position;
use App\Services\SeederCheck;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use SoftDeletes;
    use Notifiable;
    use HasRoles;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */

    protected $guarded = [];

    public function scopePrimary($query)
    {
        return $query->where('parent_id', parentID());
    }

    public function getAuthPassword()
    {
        if (auth()->getDefaultDriver() == 'web') {

            return $this->password;
        }
        return $this->systempass;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

//
    //    protected static $logAttributes = ['name', 'email', 'phone','type','avatar'];
    //    protected static $ignoreChangedAttributes = ['password','updated_at'];
    //    protected static $submitEmptyLogs = false;
    //    protected static $logOnlyDirty = true;
    //    protected static $logName = 'user';
    //
    //    public function  getDescriptionForEvent(string $eventName): string
    //    {
    //        return "you Have {$eventName} user";
    //    }

    protected static function booted()
    {
        static::updated(function ($region) {
            if (!SeederCheck::isRunning()) {
                $changes = $region->isDirty() ? $region->getDirty() : false;
                if ($changes) {
                    unset($changes['updated_at'], $changes['password']);
                    activity()
                        ->performedOn($region)
                        ->inLog('user')
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
                    unset($changes['id'], $changes['created_at'], $changes['updated_at'], $changes['user_id'], $changes['password']);
                    activity()
                        ->causedBy(auth()->user())
                        ->inLog('user')
                        ->performedOn($region)
                        ->withProperties($changes)
                        ->log(auth()->user()->name . ' Created - ' . $region->name);
                }
            }
        });

    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @param $builder
     * @return mixed
     */
    public function scopeAvailable($builder)
    {
        $builder->where(function ($query) {
            $query->where('primary_id', primaryID());
            $query->orWhere('id', auth()->id());
        });

        return $builder;
    }

    /**
     * @return BelongsToMany
     */
    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'branches_users');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User', 'parent_id');
    }

    /**
     * @return HasOne
     */
    public function position(): HasOne
    {
        return $this->hasOne(Position::class, 'id','position_id');
    }

    /**
     * @return HasOne
     */
    public function user_settings(): HasOne
    {
        return $this->hasOne('App\UserSetting');
    }
}
