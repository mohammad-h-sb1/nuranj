<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\Admin\ImageResource;
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
            'company'=>$this->company,
            'website'=>$this->website,
            'application'=>$this->application,
            'startup'=>$this->startup,
            'work_experience'=>$this->work_experience,
            'coding'=>$this->coding,
            'trade_relations'=>$this->trade_relations,
            'description'=>$this->description,
            'category'=>new CategoryResource($this->category),
            'img'=>\App\Http\Resources\User\ImageResource::collection($this->images)

        ];
    }
}
