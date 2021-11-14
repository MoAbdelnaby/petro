<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\AbstractRepoInterface;
use App\Http\Requests\PaginateRequest;
use App\Models\Region;
use App\User;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\False_;


class AbstractRepo implements AbstractRepoInterface
{
    protected   $model;

    public function __construct(string $model)
    {
        $this->model = $model;
    }

    public function findOrFail($id)
    {
        return $this->model::findOrfail($id);
    }

    public function first($id)
    {
        return $this->model::where('id', $id)->first();
    }
    public function getWhere(array $data)
    {
        return $this->model::where($data)->orderBy('id', 'DESC')->paginate(10);
    }

    public function getAll()
    {
        return $this->model::orderBy('id', 'DESC')->paginate(13);
    }

    public function restore($id)
    {
        $row = $this->model::onlyTrashed()->find($id);
        if($row)
        {
            $row->restore();
            return true ;
        }
        return false;

    }
    public function forceDelete($id)
    {
        $row = $this->model::onlyTrashed()->find($id);
        if($row)
        {
            $row->forceDelete();
            return true ;
        }
        return false;
    }


    public function bulkRestore(array $trashs)
    {
        $allRows = $this->model::onlyTrashed()->find($trashs);
        if($allRows) {
            foreach ($allRows as $row) {
                $row->restore();
            }
            return true;
        }
        return false;
    }
    public function bulkForceDelete(array $trashs)
    {
        $allRows = $this->model::onlyTrashed()->find($trashs);
        if($allRows) {
            foreach ($allRows as $row) {
                $row->forceDelete();
            }
            return true;
        }
        return false;
    }

    public function paginate(PaginateRequest $request, $wheres = [], $model = null)
    {
        if ($model !== null) {
            $this->model = $model;
        }

        $currentPage = $request->offset;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        if (count($wheres)) {
            $this->model = new $this->model;
            foreach ($wheres as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $key1 => $value1)
                        if (!is_int($key1))
                            $this->model = $this->model->where($key, $key1, $value1);
                } elseif (!is_int($key)) {
                    $this->model = $this->model->where($key, $value);
                }
            }

            if ($request->has('targetId')) {
                $this->model = $this->model->where('id', $request->input('targetId'));
            }

            return $this->model->orderBy($request->field, $request->sort)->paginate($request->limit);
        }

        return $this->model::orderBy($request->field, $request->sort)->paginate($request->limit);
    }

    public function create(array $data)
    {
        return $this->model::create($data);
    }

    public function update(array $data, $id)
    {
        $item = $this->model::where('id', $id)->first();
        return $item->update($data);
    }

    public function delete($id)
    {

        $model = $this->model::findOrFail($id);
        activity()
            ->causedBy(auth()->user())
            ->inLog(Str::lower(Str::afterLast($this->model,'\\')))
            ->performedOn($model)
            ->withProperties(['deleted_at'=>Carbon::now()->format('Y-m-d H:i:s')])
            ->log(auth()->user()->name.' Deleted - '.$model->name ?? $model->id );

        return $model->delete();

    }
}
