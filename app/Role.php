<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends \Spatie\Permission\Models\Role
{

    public function registerGlobalScopes($builder)
    {
        $builder->where('name', 'like', primarySlug() . '.%');
        return parent::registerGlobalScopes($builder);
    }
}
