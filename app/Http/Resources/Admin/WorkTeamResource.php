<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\User\UserResource;
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
            'user'=>new UserResource($this->user),
            'name'=>$this->name,
            'description'=>$this->description,
            'instagram'=>$this->instagram,
            'telegram'=>$this->telegram,
            'whatsapp'=>$this->whatsapp,
            'projects'=>$this->projects,
            'img'=>\App\Http\Resources\User\ImageResource::collection($this->images)

        ];
    }
}
