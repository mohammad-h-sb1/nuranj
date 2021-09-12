<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            'title'=>$this->title,
            'category'=>$this->category,
            'description'=>$this->description,
            'img'=>new \App\Http\Resources\User\ImageResource($this->img),
            'status'=>$this->status
        ];
    }
}
