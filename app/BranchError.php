<?php

namespace App;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;

class BranchError extends Model
{
    protected $table = "last_error_branch_views";

    public function branch() {
        return $this->belongsTo(Branch::Class,"branch_code","code");
    }
}
