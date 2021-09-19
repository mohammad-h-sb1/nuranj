<?php

namespace App\Http\Controllers\V2\Dashboard\AdminShop;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AdminShop\ProductResource;
use App\Models\V2\Product;
use App\Models\V2\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=Product::query()->where('user_id',auth()->user()->id)->paginate(\request('limit'));
        return response()->json([
            'status'=>'ok',
            'data'=>ProductResource::collection($product)
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
            'name' => ['required','string','max:50'],
            'type' => ['required',],
            'categories'=>['array'],
        ]);
        $shop=Shop::query()->where('user_id',auth()->user()->id)->pluck('id')->first();
        $data=[
            'user_id'=>auth()->user()->id,
            'shop_id'=>$shop,
            'name'=>$validData['name'],
            'type'=>$validData['type'],
            'description'=>$request->description
        ];
        $product=Product::create($data);
        $product->Shopcategories()->sync($validData['categories']);
        return response()->json([
            'status'=>'ok',
            'data'=>new ProductResource($product)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if ($product->uesr_id = auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>new ProductResource($product)
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        if ($product->uesr_id = auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>new ProductResource($product)
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product=Product::query()->where('id',$id)->where('user_id',auth()->user()->id)->first();
        if ($product){
            $validData=$this->validate($request,[
                'name' => ['required','string','max:50'],
                'categories'=>['array'],
            ]);
            $product->update([
                'user_id'=>auth()->user()->id,
                'name'=>$validData['name'],
                'description'=>$request->description,
            ]);
            $product->Shopcategories()->sync($validData['categories']);
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::query()->where('id',$id)->where('user_id',auth()->user()->id)->first();
        if ($product){
            $product->delete();
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دسترسی ندارید'
            ],403);
        }
    }

    public function status($id)
    {
        $product=Product::query()->where('id',$id)->where('user_id',auth()->user()->id)->first();
        if ($product){
            $product->update([
                'status'=> ! $product->status
            ]);
            return response()->json([
                'status'=>'ok',
                'data'=>new ProductResource($product)
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دسترسی ندارید'
            ],403);
        }
    }
}
