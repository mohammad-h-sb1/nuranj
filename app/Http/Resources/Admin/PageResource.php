<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            'user'=>new UserResource($this->user),
            'name'=>$this->name,
            'slug'=>$this->slug,
            'description'=>$this->description,
            'images'=>ImageResource::collection($this->images)
        ];

    }
}
