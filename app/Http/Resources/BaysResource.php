<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class BaysResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        $str_plate = Str::after($this->plateNumber, 'lower: ');
        $final_plate = str_replace(" ", "", $this->last_plate);

        return [
            'BayCode' => $this->area,
            'plateNumber' =>  $final_plate,
            'plateCountry' => 'Saudi Arabia',
            'plateColor' => 'White'
        ];
    }
}
