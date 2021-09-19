<?php

namespace App\Http\Resources\V2\AdminShop;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'type'=>$this->type,
            'description'=>$this->description,
            'categories'=>ShopCategoryResource::collection($this->Shopcategories),
            'status'=>$this->status
        ];
    }
}
