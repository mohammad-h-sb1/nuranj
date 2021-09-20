<?php

namespace App\Http\Resources\V2\AdminShop;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketProductResource extends JsonResource
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
            'name'=>$this->name,
        ];
    }
}
