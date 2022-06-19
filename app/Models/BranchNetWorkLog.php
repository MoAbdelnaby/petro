<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchNetWorkLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_net_work_id',
        'branch_code',
        'cpu',
        'temp',
        'memory',
        'desk'
    ];
}
