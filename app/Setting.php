<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{

    use SoftDeletes;

    protected $guarded = ['id'];

    public function registerGlobalScopes($builder)
    {
        $builder->where('primary_id', primaryID());
        return parent::registerGlobalScopes($builder);
    }

    public function imageUrl($name)
    {
        if ($this->$name) {
            return asset('media/settings/' . $this->$name);
        }

        return null;
    }

}
