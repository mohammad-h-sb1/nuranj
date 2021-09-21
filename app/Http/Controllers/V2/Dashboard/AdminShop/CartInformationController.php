<?php

namespace App\Http\Controllers\V2\Dashboard\AdminShop;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AdminShop\CartInformationResource;
use App\Models\V2\CartInformation;
use App\Models\V2\Shop;
use Illuminate\Http\Request;

class CartInformationController extends Controller
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
            'request_automatic_transfer_to_cart'=>'nullable|boolean',
            'quick_product_purchase'=>'nullable|boolean',
            'fixed_shopping_cart'=>'nullable|boolean',
            'product_is_not_sold'=>'nullable|boolean',
        ]);
        $shop=Shop::query()->where('user_id',auth()->user()->id)->pluck('id')->first();
        $data=[
            'user_id'=>auth()->user()->id,
            'shop_id'=>$shop,
            'request_automatic_transfer_to_cart'=>$request->request_automatic_transfer_to_cart,
            'quick_product_purchase'=>$request->quick_product_purchase,
            'fixed_shopping_cart'=>$request->fixed_shopping_cart,
            'product_is_not_sold'=>$request->product_is_not_sold,
        ];
        $cartInformation=CartInformation::create($data);
        return response()->json([
            'status'=>'ok',
            'data'=>new CartInformationResource($cartInformation)
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CartInformation  $cartInformation
     * @return \Illuminate\Http\Response
     */
    public function show(CartInformation $cartInformation)
    {
        if ($cartInformation->user_id == auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>new CartInformationResource($cartInformation)
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دسترسی ندارید'
            ],403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CartInformation  $cartInformation
     * @return \Illuminate\Http\Response
     */
    public function edit(CartInformation $cartInformation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CartInformation  $cartInformation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartInformation $cartInformation)
    {
        $validData=$this->validate($request,[
            'request_automatic_transfer_to_cart'=>'nullable|boolean',
            'quick_product_purchase'=>'nullable|boolean',
            'fixed_shopping_cart'=>'nullable|boolean',
            'product_is_not_sold'=>'nullable|boolean',
        ]);
        if ($cartInformation->user_id == auth()->user()->id) {
            $cartInformation->update([
                'request_automatic_transfer_to_cart' => $request->request_automatic_transfer_to_cart,
                'quick_product_purchase' => $request->quick_product_purchase,
                'fixed_shopping_cart' => $request->fixed_shopping_cart,
                'product_is_not_sold' => $request->product_is_not_sold,
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دسترسی ندارید'
            ],403);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CartInformation  $cartInformation
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartInformation $cartInformation)
    {
        //
    }
}
