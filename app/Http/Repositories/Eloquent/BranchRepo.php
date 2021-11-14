<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\BranchRepoInterface;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;


class BranchRepo extends AbstractRepo implements BranchRepoInterface
{
    public function __construct()
    {
        parent::__construct(Branch::class);
    }


    public function getactiveBranches()
    {
        return $this->model::with('region')->where('user_id', parentID())->latest()->get();
    }
}
