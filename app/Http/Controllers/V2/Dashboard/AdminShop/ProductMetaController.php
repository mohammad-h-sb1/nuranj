<?php

namespace App\Http\Controllers\V2\Dashboard\AdminShop;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AdminShop\ProductMetaResource;
use App\Models\V2\Product;
use App\Models\V2\ProductMeta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductMetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=Product::query()->where('user_id',auth()->user()->id)->pluck('id')->first();
        $productMeta=ProductMeta::query()->where('product_id',$product)->get();
        return response()->json([
            'status'=>'ok',
            'date'=>ProductMetaResource::collection($productMeta)
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
            'color_name'=>['string'],
            'color_code'=>['string'],
            'key'=>['string'],
            'value'=>['string'],
            'product_id'=>['required']
        ]);
        $productMeta=ProductMeta::create($validData);
        return response()->json([
            'status'=>'ok',
            'data'=>new ProductMetaResource($productMeta)
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductMeta  $productMeta
     * @return \Illuminate\Http\Response
     */
    public function show(ProductMeta $productMeta)
    {
        $user=$productMeta->Product->user_id;
        if ($user == auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>new ProductMetaResource($productMeta)
            ]);
        }
        else{
            return response()->json([
                'status'=>'error',
                'massage'=>'شما دسترسی ندارید'
            ],403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductMeta  $productMeta
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductMeta $productMeta)
    {
        $user=$productMeta->Product->user_id;
        if ($user == auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>new ProductMetaResource($productMeta)
            ]);
        }
        else{
            return response()->json([
                'status'=>'error',
                'massage'=>'شما دسترسی ندارید'
            ],403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductMeta  $productMeta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductMeta $productMeta)
    {
        $validData=$this->validate($request,[
            'code' => ['string','max:15','min:11'],
            'Price'=>['string'],
            'existing'=>['string'],
            'limitations'=>['string'],
            'color_name'=>['string'],
            'color_code'=>['string'],
            'key'=>['string'],
            'value'=>['string']
        ]);
        $user=$productMeta->Product->user_id;
        if ($user == auth()->user()->id){
           $productMeta->update($validData);
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
     * @param  \App\Models\ProductMeta  $productMeta
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductMeta $productMeta)
    {
        $user=$productMeta->Product->user_id;
        if ($user == auth()->user()->id){
            $productMeta->delete();
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دسترسی ندارید'
            ],403);
        }

    }
}
