<?php

namespace App\Http\Resources\User;

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
            'title'=>$this->title,
            'category'=>$this->category,
            'description'=>$this->description,
            'img'=>new ImageResource($this->img),
            'answer'=>AnswersResource::collection($this->answers)
        ];
    }
}
