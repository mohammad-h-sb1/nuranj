<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswersResource extends JsonResource
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
            'ticket'=>new \App\Http\Resources\Admin\TicketResource($this->ticket),
            'answer'=>$this->answer
        ];
    }
}
