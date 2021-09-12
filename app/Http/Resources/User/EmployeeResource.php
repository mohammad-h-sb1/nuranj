<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'user'=>new UserResource($this->user),
            'family'=>$this->family,
            'type'=>$this->type,
            'address'=>$this->address,
            'gender'=>$this->gender,
            'marital_status'=>$this->marital_status,
            'age'=>$this->age,
            'military_service_status'=>$this->military_service_status,
            'introduction_to'=>$this->introduction_to,
            'resume'=>$this->resume,
            'educational_background'=>$this->educational_background,
            'language'=>$this->language,
            'education_courses'=>$this->education_courses,
            'status'=>$this->status,
            'created_at'=>(string)$this->created_at
        ];
    }
}
