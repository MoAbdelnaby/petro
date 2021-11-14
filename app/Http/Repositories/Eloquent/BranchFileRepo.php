<?php

namespace App\Http\Repositories\Eloquent;

use App\Models\BranchFiles;


class BranchFileRepo extends AbstractRepo
{
    public function __construct()
    {
        parent::__construct(BranchFiles::class);
    }

}
