<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\EscalationRequest;
use App\Models\Escalation;
use App\Models\EscalationBranch;
use App\Models\Position;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
            return view('customer.escalations.index', [
                'escalations' => Escalation::primary()->orderBy('sort', 'ASC')->get(),
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
            $data['sort'] = Escalation::primary()->max('sort') ? Escalation::primary()->max('sort') + 1 : 0;
            $data['user_id'] = parentID();

            Escalation::create($data);

            return redirect(url('customer/escalations'))->with('success', __('app.escalation_created_success'));
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
     * @return RedirectResponse
     */
    public function destroy(Escalation $escalation)
    {
        try {
            $escalation->delete();

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
