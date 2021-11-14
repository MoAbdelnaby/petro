<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Form;
use App\Http\Resources\UserSearchResource;

class UserFormSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->form->name,
            'user'=>[
                'id'=>$this->user->id,
                'name'=>$this->user->name,
                'department' => $this->user->department->name,
                'position' => $this->user->position->title,
            ]
            
        ];
    }
}
