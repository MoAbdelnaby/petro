<?php

namespace App;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BranchStatus extends Model
{
    protected $table = "branch_status";

    protected $fillable = ['branch_code', 'branch_name', 'last_error', 'last_connected', 'status'];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::Class, "branch_code", "code");
    }

}
