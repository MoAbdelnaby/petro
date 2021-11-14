<?php

namespace App\Http\Repositories\Interfaces;

use App\Http\Requests\PaginateRequest;
use Illuminate\Support\Facades\Request;
use PhpParser\Node\Expr\Array_;

interface AbstractRepoInterface
{
    public function findOrFail($id);
    public function first($id);
    public function getAll();
    public function getWhere(Array $data);
    public function create(Array $data);

    public function update(Array $data, $id);

    public function delete($id);
    public function paginate(PaginateRequest $request);
}
