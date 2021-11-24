<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchStatus extends Model
{
    protected $table = "branch_status";
    protected $fillable = ['branch_code','branch_name','last_error','last_connected','status'];
}
