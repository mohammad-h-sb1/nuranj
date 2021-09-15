<?php

namespace App\Http\Resources\V2\Admin;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryShopResource extends JsonResource
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
            'status'=>$this->status
        ];
    }
}
