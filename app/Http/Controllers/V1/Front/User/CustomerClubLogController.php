<?php

namespace App\Http\Controllers\V1\Front\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\CustomerClubResource;
use App\Models\CustomerClub;
use App\Models\CustomerClubLog;
use Illuminate\Http\Request;

class CustomerClubLogController extends Controller
{
    public function login($id)
    {
        $customer=CustomerClub::query()->where('id',$id)->first();
        if ($customer->status == 1 & auth()->user()->type == $customer->type){
            $data=[
                'user_id'=>auth()->user()->id,
                'customer_club_id'=>$customer->id
            ];
            CustomerClubLog::create($data);
            return response()->json([
                'status'=>'ok',
                'data'=>new CustomerClubResource($customer)
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'manager'=>'شما دسترسی ندارید',
            ]);
        }
    }

    public function logout($id)
    {
        $customer=CustomerClubLog::query()->where('id',$id)->first();
        if ($customer->user_id == auth()->user()->id & $customer->customerClub->status ==1 ){
            $customer->delete();
        }
        else{
            return response()->json([
                'status'=>'Error',
                'manager'=>'شما دسترسی ندارید',
            ]);
        }
    }
}
