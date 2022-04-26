<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\EscalationRequest;
use App\Models\Escalation;
use App\Models\EscalationBranch;
use App\Models\Position;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class EscalationController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:list-escalations', ['only' => ['index', 'store']]);
//        $this->middleware('permission:create-escalations', ['only' => ['create', 'store']]);
//        $this->middleware('permission:edit-escalations', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:delete-escalations', ['only' => ['destroy', 'delete_all']]);
    }

    /**
     * @return View|JsonResponse|RedirectResponse
     */
    public function index()
    {
        try {
            $escalations = Escalation::primary()->orderBy('sort', 'ASC')
                ->selectRaw('position_id as position, time_minute as time')
                ->get()
                ->toArray();

            return view('customer.escalations.index', [
                'escalations' => $escalations,
                'positions' => Position::primary()->latest()->get()
            ]);
        } catch (\Exception $e) {
            return unKnownError($e->getMessage());
        }
    }

    /**
     * @param EscalationRequest $request
     * @return RedirectResponse
     */
    public function store(EscalationRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();
            Escalation::query()->delete();

            $escalations = json_decode($data['items'], true);

            $data['user_id'] = parentID();
            foreach ($escalations as $index => $escalation) {
                if ($escalation['position'] == 0) continue;
                $data['sort'] = $index;
                $data['time_minute'] = $escalation['time'];
                $data['position_id'] = $escalation['position'];
                Escalation::create($data);
            }

            return redirect(url('customer/escalations'))->with('success', __('app.escalation_updated_success'));
        } catch (\Exception $e) {
            return unKnownError($e->getMessage());
        }
    }

    /**
     * @param EscalationRequest $request
     * @param Escalation $escalation
     * @return RedirectResponse
     */
    public function update(EscalationRequest $request, Escalation $escalation): RedirectResponse
    {
        try {
            $data = $request->validated();
            $escalation->position_id = $data['position_id'];
            $escalation->time_minute = $data['time_minute'];
            $escalation->save();

            return redirect(url('customer/escalations'))->with('success', __('app.escalation_updated_success'));
        } catch (\Exception $e) {
            return unKnownError($e->getMessage());
        }
    }

    /**
     * @param Escalation $escalation
     * @return Application|JsonResponse|RedirectResponse|Redirector
     */
    public function destroy(Escalation $escalation)
    {
        try {
            $escalation->delete();

            if(\request()->wantsJson()){
                return response()->json(['danger' => __('app.escalation_deleted_success')]);
            }
            return redirect(url('customer/escalations'))->with('success', __('app.escalation_deleted_success'));

        } catch (\Exception $e) {
            return unKnownError($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateBranchStatus(Request $request)
    {
        $escalationBranch = EscalationBranch::find($request->escalation_branch_id);
        if ($escalationBranch) {
            $escalationBranch->noticed = true;
            $escalationBranch->save();
            return back()->with('success', __('app.action_took_success'));
        }

        return back()->with('danger', 'Error In Take Action');
    }
}
