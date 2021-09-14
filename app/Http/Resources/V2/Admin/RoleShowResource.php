<?php

namespace App\Http\Resources\V2\Admin;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleShowResource extends JsonResource
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
            'label'=>$this->label,
            'users'=>UserResource::collection($this->users),
            'permissions'=>PermissionResource::collection($this->permissions)
        ];
    }
}
