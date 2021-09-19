<?php

namespace App\Http\Resources\V2\AdminShop;

use App\Models\V2\Shop;
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
            'name'=>$this->name,
            'category'=>$this->categoryShop,
            'province_id'=>$this->province_id,
            'city_id'=>$this->city_id,
            'url'=>$this->url,
            'phone'=>$this->phone,
            'description'=>$this->description,
            'status'=>$this->status,
            'expired_at'=>$this->expired_at,
            'showMeta'=>new ShopMetaResource($this->ShopMeta)
        ];


    }
}
