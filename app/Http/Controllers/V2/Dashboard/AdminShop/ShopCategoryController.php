<?php

namespace App\Http\Controllers\V2\Dashboard\AdminShop;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AdminShop\ShopCategoryResource;
use App\Models\V2\Shop;
use App\Models\V2\ShopCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shopCategory=ShopCategory::query()->where('user_id',auth()->user()->id)->paginate(\request('limit'));
        return response()->json([
            'status'=>'ok',
            'date'=>ShopCategoryResource::collection($shopCategory)
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
        ]);
        $shop=Shop::query()->where('user_id',auth()->user()->id)->pluck('id')->first();
        $data=[
            'user_id'=>auth()->user()->id,
            'shop_id'=>$shop,
            'parent_id'=>$request->parent_id,
            'name'=>$validData['name'],
            'description'=>$request->description,
        ];
        $shop_category=ShopCategory::create($data);
        return response()->json([
            'status'=>'ok',
            'data'=>new ShopCategoryResource($shop_category)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShopCategory  $shopCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ShopCategory $shopCategory)
    {
        if ($shopCategory->user_id == auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>new ShopCategoryResource($shopCategory)
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
     * @param  \App\Models\ShopCategory  $shopCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopCategory $shopCategory)
    {
        if ($shopCategory->user_id == auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>new ShopCategoryResource($shopCategory)
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
     * @param  \App\Models\ShopCategory  $shopCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShopCategory $shopCategory)
    {
        $validData=$this->validate($request,[
            'name' => ['required','string','max:50'],
        ]);
        $data=[
            'name'=>$validData['name'],
            'parent_id'=>$request->parent_id,
            'description'=>$request->description,
        ];
        $shopCategory->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShopCategory  $shopCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShopCategory $shopCategory)
    {
        $shopCategory->delete();
    }

    public function status($id)
    {
        $shopCategory=ShopCategory::query()->where('id',$id)->first();
        if ($shopCategory->user_id == auth()->user()->id){
            $shopCategory->update([
                'status'=> ! $shopCategory->status
            ]);
            return response()->json([
                'status'=>'ok',
                'data'=>new ShopCategoryResource($shopCategory)
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دسترسی ندارید'
            ],403);
        }
    }

    public function statusMenu($id)
    {
        $shopCategory=ShopCategory::query()->where('id',$id)->first();
        if ($shopCategory->user_id == auth()->user()->id){
            $shopCategory->update([
                'status_menu'=> ! $shopCategory->status_menu
            ]);
            return response()->json([
                'status'=>'ok',
                'data'=>new ShopCategoryResource($shopCategory)
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
