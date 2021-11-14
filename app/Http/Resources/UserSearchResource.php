<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSearchResource extends JsonResource
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
            'index' => $GLOBALS['index']++,
            'id' => $this->id,
            'text' => $this->name,
            'department' => $this->department,
            'position' => $this->position,
            'date' => $this->created_at->format('d/m/Y'),
        ];
    }
}
