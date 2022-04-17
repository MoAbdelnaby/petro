<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'parent_id', 'user_id'];

    /**
     * @param $query
     * @return mixed
     */
    public function scopePrimary($query)
    {
        return $query->where('user_id', parentID());
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeChild($query)
    {
        return $query->where('parent_id', '<>', null);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeParent($query)
    {
        return $query->where('parent_id', '=', null);
    }

    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'position_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function parentPosition(): HasOne
    {
        return $this->hasOne(Position::class, 'id', 'parent_id');
    }
}
