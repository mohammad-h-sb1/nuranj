<?php

namespace App\Http\Resources\V2\AdminShop;

use Illuminate\Http\Resources\Json\JsonResource;

class CartInformationResource extends JsonResource
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
            'request_automatic_transfer_to_cart'=>$this->request_automatic_transfer_to_cart,
            'quick_product_purchase'=>$this->quick_product_purchase,
            'fixed_shopping_cart'=>$this->fixed_shopping_cart,
            'product_is_not_sold'=>$this->product_is_not_sold
        ];    }
}
