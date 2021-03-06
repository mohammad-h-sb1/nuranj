<?php

namespace App\Http\Resources\V2\Front;

use App\Http\Resources\User\UserResource;
use App\Http\Resources\V2\AdminShop\ShopMetaResource;
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
            'category'=>$this->categoryShop->name,
            'name'=>$this->name,
            'province'=>$this->province_id,
            'city_id'=>$this->city_id,
            'url'=>$this->url,
            'phone'=>$this->phone,
            'description'=>$this->description,
            'shopMeta'=>new ShopMetaResource($this->shopMeta)
        ];
    }
}
