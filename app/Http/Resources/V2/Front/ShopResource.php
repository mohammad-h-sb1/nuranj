<?php

namespace App\Http\Resources\V2\Front;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
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
//            'user'=>new UserResource($this->user),
            'url'=>$this->url,
            'mobile'=>$this->user->mobile
        ];
    }
}
