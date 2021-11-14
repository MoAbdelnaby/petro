<?php

namespace App\Http\Repositories\Interfaces;

interface BranchModelsRepoInterface
{
    public function getactiveBranches();
    public function getactiveModels();
    public function getActiveUserModels();
}
