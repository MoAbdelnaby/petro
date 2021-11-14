<?php

namespace App\Http\Resources;

use App\Models\UserForm;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Activitylog\Models\Activity;

class UserFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        if ($request->has('form') && $request->has('user')) {
            $userForm = UserForm::where('form_id', $request->form->id)->where('user_id', $request->user->id)->firstOrFail();
        } else {
            $userForm = $this;
        }
        //UserForm::find(7)->update(['action' => 'Reviewed', 'status' => 'Cancelled']);
        // action activities
        $action_activities = Activity::where('subject_id', $userForm->id)->where('subject_type', UserForm::class)->get();
        $actions = [];
        foreach ($action_activities as $action_activity) {
            $action_activity->properties = json_decode($action_activity->properties);
            if (isset($action_activity->properties['attributes']['action'])) {
                $actions[$action_activity->properties['attributes']['action']] = $action_activity->created_at->format('d/m/Y');
            }
        }

        $reviewedPercent = 0;
        $items = 0;
        $accepted = 0;
        foreach ($userForm->form->pages as $page) {
            foreach ($page->items as $item) {
                if ($item->type == 'label'||$item->type == 'line') continue;
                $items++;
                if ($item->type == 'table' && $item->filling != '') {
                    $item->filling = json_decode($item->filling);
                    if ($item->filling->review)
                        $accepted++;

                    $itemFilled = false;
                    if ($item->filling->value != null) {
                        $item->filling->value = json_decode($item->filling->value);
                        foreach ($item->filling->value as $children) {
                            if ($itemFilled) break;
                            foreach ($children as $child) {
                                if ($itemFilled) break;
                                if (isset($child->items) )
                                    foreach ($child->items as $childItem) {
                                        if ($itemFilled) break;
                                        if ($childItem->type != 'label' && $childItem->value) {
                                            $reviewedPercent++;
                                            $itemFilled = true;
                                        }
                                    }
                            }
                        }
                    }
                } elseif ($item->type == 'tree' && $item->filling != '') {
                    if ($item->filling->review)
                        $accepted++;

                    $itemFilled = false;
                    if ($item->filling->value != null) {
                        $item->filling->value = json_decode($item->filling->value);
                        if ($item->filling->value->text) {
                            $reviewedPercent++;
                            $itemFilled = true;
                        } else
                            foreach ($item->filling->value->nodes as $node) {
                                if ($node->text) {
                                    $reviewedPercent++;
                                    $itemFilled = true;
                                    break;
                                }
                                foreach ($node->nodes as $node2) {
                                    if ($node2->text) {
                                        $reviewedPercent++;
                                        $itemFilled = true;
                                        break;
                                    }
                                    foreach ($node2->nodes as $node3) {
                                        if ($node3->text) {
                                            $reviewedPercent++;
                                            $itemFilled = true;
                                            break;
                                        }
                                        foreach ($node3->nodes as $node4) {
                                            if ($node4->text) {
                                                $reviewedPercent++;
                                                $itemFilled = true;
                                                break;
                                            }
                                            foreach ($node4->nodes as $node5) {
                                                if ($node5->text) {
                                                    $reviewedPercent++;
                                                    $itemFilled = true;
                                                    break;
                                                }
                                                foreach ($node5->nodes as $node6) {
                                                    if ($node6->text) {
                                                        $reviewedPercent++;
                                                        $itemFilled = true;
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                    }
                } elseif ($item->filling && $item->filling->value) {
                    $reviewedPercent++;
                }
            }
        }

        if ($items) {
            $reviewedPercent /= $items;
            $accepted /= $items;
        }

        return [
            'id' => $userForm->id,
            'name' => $userForm->form->name,
            'department' => $userForm->form->department,
            'job_level' => $userForm->form->job_level,
            'expires_at' => $userForm->form->expires_at,
            'user' => [
                'name' => $userForm->user->name,
                'department' => $userForm->user->department->name ?? '',
                'position' => $userForm->user->position,
            ],
            'assigned_at' => $userForm->created_at->diffForHumans(),
            'updated_at' => $userForm->fill ? $userForm->fill->updated_at->diffForHumans() : $userForm->updated_at->diffForHumans(),
            'notifications' => $userForm->notifications,
            'status' => $userForm->status,
            'available_jobs' => json_decode($userForm->available_jobs),
            'prof' => json_decode($userForm->prof),
            'review_result' => $userForm->review_result,
            'action' => $userForm->action,
            'action_activities' => $actions,
            'reviewedPercent' => intval($reviewedPercent * 100),
            'acceptedPercent' => intval($accepted * 100)
        ];
    }
}
