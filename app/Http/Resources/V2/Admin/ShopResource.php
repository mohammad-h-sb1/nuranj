<?php

namespace App\Http\Resources\V2\Admin;

use App\Http\Resources\User\UserResource;
use App\Http\Resources\V2\Admin\CategoryShopResource;
use App\Models\User;
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
        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $this->expired_at);
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $this->created_at);
        return[
            'user'=>new UserResource($this->user),
            'category'=>new CategoryShopResource($this->categoryShop),
            'name'=>$this->name,
            'province'=>$this->province_id,
            'city_id'=>$this->city_id,
            'url'=>$this->url,
            'phone'=>$this->phone,
            'description'=>$this->description,
            'status'=>$this->status,
            'expired_at'=>$this->expired_at,
            'diff_in_days'=>$to->diffInDays($from)
        ];
    }
}
