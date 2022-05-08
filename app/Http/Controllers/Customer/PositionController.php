<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\PositionRepo;
use App\Http\Requests\PositionRequest;
use App\Http\Resources\PositionResource;
use App\Models\Position;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    protected PositionRepo $repo;

    /**
     * @param PositionRepo $repo
     */
    public function __construct(PositionRepo $repo)
    {
//        $this->middleware('permission:list-positions', ['only' => ['index', 'store']]);
//        $this->middleware('permission:create-positions', ['only' => ['create', 'store']]);
//        $this->middleware('permission:edit-positions', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:delete-positions', ['only' => ['destroy', 'delete_all']]);
        $this->repo = $repo;
    }

    /**
     * @return View|JsonResponse|RedirectResponse
     */
    public function index()
    {
        try {
            $query = $this->repo->orderBy('parent_id', 'ASC');
            $trashs = $this->repo->onlyTrashed()->withCount('users')->primary()->get();

            $positions = PositionResource::make($query->get());

            $tree = "<ul class='tree'>";
            foreach ($positions as $position) {
                $tree .= "<li><span>{$position['name']}
                                <a class='btn btn-sm btn-info' style='font-size: 10px;width: 27px;'
                           href=" . route('positions.edit', [$position['id']]) . " >
                            <i class='fas fa-edit' ></i>
                        </a >
                        <a class='btn btn-sm btn-danger' style='font-size: 10px;width: 27px;'
                           onclick=delete_alert(" . $position['id'] . ")>
                           <i class='fas fa-trash-alt'></i>
                           </a></span>";
                if (count($position['children'])) {
                    $tree .= $this->childView($position);
                }
            }
            $tree .= '<ul>';

            return view('customer.positions.index', compact( 'tree', 'trashs','positions'));

        } catch (\Exception $e) {
            return unKnownError($e->getMessage());
        }
    }

    /**
     * @param $position
     * @return string
     */
    private function childView($position)
    {
        if(count($position['children'])) {
            $html = '<ul>';
            foreach ($position['children'] as $arr) {
                $html .= "<li><span>{$arr['name']}
                        <a class='btn btn-sm btn-info' style='font-size: 10px;width: 27px;'
                       href=" . route('positions.edit', [$arr['id']]) . " >
                        <i class='fas fa-edit' ></i>
                    </a >
                    <a class='btn btn-sm btn-danger' style='font-size: 10px;width: 27px;'
                       onclick=delete_alert(" . $arr['id'] . ")>
                       <i class='fas fa-trash-alt'></i>
                       </a></span>
                   ";

                if (count($arr['children'])) {
                    $html .= $this->childView($arr);
                } else {
                    $html .= "</li > ";
                }
            }
            $html .= "</ul > ";
        }

        return $html;
    }

    /**
     * @return Application|Factory|View|JsonResponse|RedirectResponse
     */
    public function create()
    {
        try {
            $positions = $this->repo->primary()->get();

            return view('customer.positions.create', compact('positions'));
        } catch (\Exception $e) {
            return unKnownError($e->getMessage());
        }
    }

    /**
     * @param PositionRequest $request
     * @return RedirectResponse
     */
    public function store(PositionRequest $request): RedirectResponse
    {
        try {
            $this->repo->create($request->validated() + ['user_id' => parentID()]);
            return redirect(url('customer/positions'))->with('success', __('app.position_created_success'));

        } catch (\Exception $e) {
            return unKnownError($e->getMessage());
        }
    }

    /**
     * @param Position $position
     * @return Application|Factory|View|JsonResponse|RedirectResponse
     */
    public function edit(Position $position)
    {
        try {
            $positions = $this->repo->primary()->where('id', '!=', $position->id)->get();

            return view('customer.positions.edit', compact('position', 'positions'));
        } catch (\Exception $e) {
            return unKnownError($e->getMessage());
        }
    }

    /**
     * @param PositionRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(PositionRequest $request, $id): RedirectResponse
    {
        try {
            $this->repo->update($request->validated() + ['user_id' => parentID()], $id);

            return redirect(url('customer/positions'))->with('success', __('app.position_updated_success'));
        } catch (\Exception $e) {
            return unKnownError($e->getMessage());
        }
    }

    /**
     * @param Position $position
     * @return JsonResponse
     */
    public function destroy(Position $position): JsonResponse
    {
        try {
            $position->delete();

            return response()->json(['danger' => __('app.position_deleted_success')]);

        } catch (\Exception $e) {
            return unKnownError($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function restore(Request $request): RedirectResponse
    {
        try {
            $this->repo->onlyTrashed()->find($request->trashs)->each(function($e) {
                $e->restore();
            });

            return redirect(url('customer/positions'))->with('success', __('app.success_restore_message'));
        } catch (\Exception $e) {
            return unKnownError($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function forceDelete(Request $request): RedirectResponse
    {
        try {
            $this->repo->onlyTrashed()->find($request->trashs)->each(function($e) {
                $e->forceDelete();
            });

            return redirect(url('customer/positions'))->with('success', __('app.success_delete_message'));
        } catch (\Exception $e) {
            return unKnownError($e->getMessage());
        }
    }
}
