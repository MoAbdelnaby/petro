<?php

namespace App;

use App\Models\Branch;
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

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function branch() {
        return $this->belongsTo(Branch::Class,"branch_code","code");
    }
}
