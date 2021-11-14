<?php

namespace App\Http\Resources;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class VehiclesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $str_plate = Str::after($this->plateNumber, 'lower: ');
        $final_plate = str_replace(".", "", $str_plate);

        return [
            'BayCode' => $this->BayCode,
            'plateNumber' => $final_plate,
            'plateCountry' => $this->plateCountry,
            'plateColor' => $this->plateColor,
            'checkInDate' => $this->checkInDate,
            'checkOutDate' => $this->checkOutDate
        ];
    }
}
