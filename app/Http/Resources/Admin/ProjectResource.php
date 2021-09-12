<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\User\UserResource;
use App\Models\Image;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'user_id'=>new UserResource($this->user),
            'level'=>$this->level,
            'company'=>$this->company,
            'website'=>$this->website,
            'application'=>$this->application,
            'startup'=>$this->startup,
            'work_experience'=>$this->work_experience,
            'coding'=>$this->coding,
            'trade_relations'=>$this->trade_relations,
            'description'=>$this->description,
            'work team'=>WorkTeamResource::collection($this->workTeams),
            'category'=>new CategoryResource($this->category),
            'img'=>\App\Http\Resources\User\ImageResource::collection($this->images)

        ];
    }
}
