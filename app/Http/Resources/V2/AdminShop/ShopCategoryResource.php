<?php

namespace App\Http\Resources\V2\AdminShop;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopCategoryResource extends JsonResource
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
            'parent'=>new ShopCategoryResource($this->parent),
            'description'=>$this->description,
            'status'=>$this->status,
            'status_menu'=>$this->status_menu
        ];
    }
}
