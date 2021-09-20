<?php

namespace App\Http\Resources\V2\AdminShop;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductMetaResource extends JsonResource
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
            'color_name'=>$this->color_name,
            'color_code'=>$this->color_code,
            'key'=>$this->key,
            'value'=>$this->value,
//            'product'=>new ProductResource($this->product)
        ];
    }
}
