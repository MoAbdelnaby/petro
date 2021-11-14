<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Branch;

class ConnectionSpeed extends Model
{
    protected $guarded = [];
    protected $with = ['branch'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
