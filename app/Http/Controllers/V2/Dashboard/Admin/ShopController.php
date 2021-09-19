<?php

namespace App\Http\Controllers\V2\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\Admin\ShopResource;
use App\Models\V2\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\Rule;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop=Shop::query()->paginate(\request('limit'));
        return response()->json([
            'status'=>'ok',
            'data'=>ShopResource::collection($shop)
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shop=Shop::query()->where('id',$id)->first();
        if ($shop) {
            return response()->json([
                'status' => 'ok',
                'data' => new ShopResource($shop)
            ]);
        }
        else{
            return response()->json([
                'status'=>'error',
                'massage'=>'وجود ندارد'
            ],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shop=Shop::query()->where('id',$id)->first();
        if ($shop) {
            return response()->json([
                'status' => 'ok',
                'data' => new ShopResource($shop)
            ]);
        }
        else{
            return response()->json([
                'status'=>'error',
                'massage'=>'وجود ندارد'
            ],404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $shop=Shop::query()->where('id',$id)->first();
        $validData=$this->validate($request,[
            'name' => ['required','string',Rule::unique('shops','name')->ignore($shop->id),'max:255'],
            'category_shop_id' => ['required'],
            'province_id' => ['required'],
            'city_id' => ['required'],
            'url' => ['required',Rule::unique('shops','url')->ignore($shop->id)],
            'phone' => ['required ',Rule::unique('shops','phone')->ignore($shop->id),'min:6','max:9'],
            'description'=>['string'],
        ]);
        $shop->update($validData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Shop::query()->where('id',$id)->delete();
    }

    public function status($id)
    {
        $shop=Shop::query()->where('id',$id)->first();
        $shop->update([
            'status'=>! $shop->status
        ]);

        return response()->json([
            'status' => 'ok',
            'data' => new ShopResource($shop)
        ]);
    }
}
