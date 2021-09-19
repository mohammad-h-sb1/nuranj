<?php

namespace App\Http\Controllers\V2\Dashboard\AdminShop;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AdminShop\ShopStingTypeMetaValueResource;
use App\Models\V2\ShopStingMetaValue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopStingMetaValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'key' => ['string',],
            'shop_sting_type_id'=>['required']
        ]);
        $data=[
            'key'=>$validData['key'],
            'shop_sting_type_id'=>$request->shop_sting_type_id,
            'status'=>$request->status,
        ];
        $shopStingTypeMeta=ShopStingMetaValue::create($data);
        return response()->json([
            'status'=>'ok',
            'data'=>new ShopStingTypeMetaValueResource($shopStingTypeMeta)
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShopStingMetaValue  $shopStingMetaValue
     * @return \Illuminate\Http\Response
     */
    public function show(ShopStingMetaValue $shopStingMetaValue)
    {
       if ($shopStingMetaValue->ShopStingType->Shop->user_id == auth()->user()->id){
           return response()->json([
               'status'=>'ok',
               'data'=>new ShopStingTypeMetaValueResource($shopStingMetaValue)
           ]);
       }
       else{
           return response()->json([
               'status'=>'Error',
               'massage'=>'شما دترسی ندارید'
           ],403);
       }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShopStingMetaValue  $shopStingMetaValue
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopStingMetaValue $shopStingMetaValue)
    {
        if ($shopStingMetaValue->ShopStingType->Shop->user_id == auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>new ShopStingTypeMetaValueResource($shopStingMetaValue)
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دترسی ندارید'
            ],403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShopStingMetaValue  $shopStingMetaValue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShopStingMetaValue $shopStingMetaValue)
    {
        if ($shopStingMetaValue->ShopStingType->Shop->user_id == auth()->user()->id){
            $validData=$this->validate($request,[
                'key' => ['string',],
                'shop_sting_type_id'=>['required']
            ]);
            $shopStingMetaValue->update($validData);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دترسی ندارید'
            ],403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShopStingMetaValue  $shopStingMetaValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShopStingMetaValue $shopStingMetaValue)
    {
        if ($shopStingMetaValue->ShopStingType->Shop->user_id == auth()->user()->id){
            $shopStingMetaValue->delete();
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دترسی ندارید'
            ],403);
        }

    }
}
