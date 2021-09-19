<?php

namespace App\Http\Resources\V2\AdminShop;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopMetaResource extends JsonResource
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
            'phone2'=>$this->phone2,
            'instagram'=>$this->instagram,
            'telegram'=>$this->telegram,
            'logo'=>$this->logo,
            'favicon'=>$this->favicon
        ];
    }
}
