<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\User\ProfileResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
            'project'=>new ProjectResource($this->project),
//            'profile'=>new ProfileResource($this->profile),
            'work Team'=>new WorkTeamResource($this->wortTeam),
            'url'=>$this->url,
            'status'=>$this->status
        ];
    }
}
