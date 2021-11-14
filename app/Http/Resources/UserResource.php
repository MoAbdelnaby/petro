<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed email
 * @property mixed phone
 * @property mixed avatar
 * @property mixed type
 * @property mixed position
 * @property mixed active
 * @property mixed roles
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar' => $this->avatar,
            'mailNotify' => $this->mail_notify,
            'type' => $this->type,
            'department' => $this->department,
            'position' => $this->position,
            'active' => $this->active,
            'domain' => $this->domain,
            'guid' => $this->guid,
            'roles' => $this->roles ? $this->roles->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'permissions' => $role->permissions ? $role->permissions->map(function ($permission) {
                        return [
                            'name' => $permission->name
                        ];
                    }) : []
                ];
            }) : [],

        ];
    }
}
