<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'mobile'=>$this->mobile,
            'email'=>$this->email,
            'type'=>$this->type,
            'api_token'=>$this->api_token,
            'two_factory_type'=>$this->two_factory_type,
            'created_at'=>(string)$this->created_at,
            'date_of_birth'=>$this->date_of_birth,
            'national_code'=>$this->national_code,
            'national_code_img_url'=>$this->national_code_img_url
        ];
    }
}
