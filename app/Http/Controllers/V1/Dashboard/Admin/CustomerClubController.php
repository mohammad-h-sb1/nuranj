<?php

namespace App\Http\Controllers\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CustomerClubResource;
use App\Models\CustomerClub;
use App\Models\CustomerClubLog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customerClub=CustomerClub::all();
        $count=count($customerClub);
        $active=$customerClub->where('status',1);
        $inactive=$customerClub->where('status',0);
        $countInactive=count($inactive);
        $countActive=count($active);
        return response()->json([
            'status'=>'ok',
            'data'=>[
                'customer'=>CustomerClubResource::collection($customerClub),
                'count'=>$count,
                'active'=>$countActive,
                'inactive'=>$countInactive
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validData=$this->validate($request,[
            'name' => 'required|string|max:255',
        ]);
        $customerClub=CustomerClub::create([
            'user_id'=>auth()->user()->id,
            'name'=>$validData['name'],
            'type'=>$request->type
        ]);
        return response()->json([
            'status'=>'ok',
            'data'=>new CustomerClubResource($customerClub)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerClub  $customerClub
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerClub $customerClub)
    {
        $customer=$customerClub->customerClubLog;
        $countUser=count($customer);
        return response()->json([
            'status'=>'ok',
            'data'=>[
                'customer'=>new CustomerClubResource($customerClub),
                'countUser'=>$countUser
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerClub  $customerClub
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerClub $customerClub)
    {
        return response()->json([
            'status'=>'ok',
            'data'=>new CustomerClubResource($customerClub)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerClub  $customerClub
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerClub $customerClub)
    {
        $validData=$this->validate($request,[
            'name' => 'required|string|max:255',
        ]);
        $customerClub->update([
            'name'=>$validData['name'],
            'type'=>$request->type,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerClub  $customerClub
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerClub $customerClub)
    {
        $customerClub->delete();
    }

    public function status($id)
    {
        $customerClub=CustomerClub::query()->where('id',$id)->first();
        $customerClub->update([
            'status'=>!$customerClub->status
        ]);
    }
}
