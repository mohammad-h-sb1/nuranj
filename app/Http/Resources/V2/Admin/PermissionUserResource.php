<?php

namespace App\Http\Resources\V2\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionUserResource extends JsonResource
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
            'type'=>$this->type,
            'permissions'=>PermissionResource::collection($this->permissions),
            'roles'=>RoleResource::collection($this->roles),
        ];
    }
}
