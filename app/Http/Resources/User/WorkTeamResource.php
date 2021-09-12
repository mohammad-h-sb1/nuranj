<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkTeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'name'=>$this->name,
            'description'=>$this->description,
            'instagram'=>$this->instagram,
            'telegram'=>$this->telegram,
            'whatsapp'=>$this->whatsapp,
        ];
    }
}
