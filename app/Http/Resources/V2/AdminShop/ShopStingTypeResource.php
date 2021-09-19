<?php

namespace App\Http\Resources\V2\AdminShop;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopStingTypeResource extends JsonResource
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
            'key'=>$this->key,
            'value'=>$this->value,
            'shopSting'=>new ShopStingResource($this->shopSting),
            'shopStingTypeMeta'=>ShopStingTypeMetaValueResource::collection($this->shopStingMetaValues)
        ];
    }
}
