<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchNetWork extends Model
{
    protected $table = "branch_net_works";

    protected $fillable = [
        'branch_code',
        'user_id',
        'error',
        'status'
    ];
}
