<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminFormSearchResource extends JsonResource
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
            'index' => $GLOBALS['index']++,
            'id' => $this->id,
            'text' => $this->name ?? '',
            'user' => $this->user,
            'status' => $this->status,
            'action' => $this->action,
            'date' => $this->created_at->format('d/m/Y'),
            'expires_at' => $this->created_at->format('d/m/Y'),
            'department' => $this->department,
            'job_level' => $this->job_level,
        ];
    }
}
