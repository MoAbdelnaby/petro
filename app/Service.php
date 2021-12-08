<?php

namespace App;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $guarded = [];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
