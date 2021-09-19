<?php

namespace App\Http\Controllers\V2\Dashboard\AdminShop;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AdminShop\ShopStingTypeResource;
use App\Models\V2\Shop;
use App\Models\V2\ShopStingType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopStingTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop=Shop::query()->where('user_id',auth()->user()->id)->pluck('id')->first();
        $shopStingType=ShopStingType::query()->where('shop_id',$shop)->paginate(\request('limit'));
        return response()->json([
            'status'=>'ok',
            'data'=>ShopStingTypeResource::collection($shopStingType)
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
            'key' => ['required',],
            'value' => ['required',],
            'shop_sting_id' => ['required',],
        ]);
        $shop=Shop::query()->where('user_id',auth()->user()->id)->pluck('id')->first();
        $data=[
            'shop_id'=>$shop,
            'shop_sting_id'=>$validData['shop_sting_id'],
            'key'=>$validData['key'],
            'value'=>$validData['value']
        ];
        $shopStingType=ShopStingType::create($data);
        return response()->json([
            'status'=>'ok',
            'data'=>new ShopStingTypeResource($shopStingType )
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShopStingType  $shopStingType
     * @return \Illuminate\Http\Response
     */
    public function show(ShopStingType $shopStingType)
    {
        if ($shopStingType->shop->user_id == auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>new ShopStingTypeResource($shopStingType )
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massager'=>'شما دسترسی ندراید'
            ],403);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShopStingType  $shopStingType
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopStingType $shopStingType)
    {

        if ($shopStingType->shop->user_id == auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>new ShopStingTypeResource($shopStingType )
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massager'=>'شما دسترسی ندراید'
            ],403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShopStingType  $shopStingType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShopStingType $shopStingType)
    {
        $validData=$this->validate($request,[
            'key' => ['required',],
            'value' => ['required',],
            'shop_sting_id' => ['required',],
        ]);
        if ($shopStingType->shop->user_id == auth()->user()->id){
            $shopStingType->update($validData);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massager'=>'شما دسترسی ندراید'
            ],403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShopStingType  $shopStingType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShopStingType $shopStingType)
    {
        if ($shopStingType->shop->user_id == auth()->user()->id){
            $shopStingType->delete();
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massager'=>'شما دسترسی ندراید'
            ],403);
        }
    }
}
