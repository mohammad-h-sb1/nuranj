<?php

namespace App\Http\Controllers\V2\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AdminShop\ShopStingResource;
use App\Models\V2\Shop;
use App\Models\V2\ShopSting;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopStingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shopSting=ShopSting::query()->paginate(\request('limit'));
        return response()->json([
            'status'=>'ok',
            'data'=>ShopStingResource::collection($shopSting)
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
            'name' => ['required','string'],
            'description' => ['required',]
        ]);
        $data=[
            'user_id'=>auth()->user()->id,
            'name'=>$validData['name'],
            'description'=>$validData['description']
        ];
        $shopSting=ShopSting::create($data);
        return response()->json([
            'status'=>'ok',
            'data'=>new ShopStingResource($shopSting)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShopSting  $shopSting
     * @return \Illuminate\Http\Response
     */
    public function show(ShopSting $shopSting)
    {
        return response()->json([
            'status'=>'ok',
            'data'=>new ShopStingResource($shopSting)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShopSting  $shopSting
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopSting $shopSting)
    {
        return response()->json([
            'status'=>'ok',
            'data'=>new ShopStingResource($shopSting)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShopSting  $shopSting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShopSting $shopSting)
    {
        $validData=$this->validate($request,[
            'name' => ['required','string'],
            'description' => ['required',]
        ]);
        $shopSting->update($validData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShopSting  $shopSting
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShopSting $shopSting)
    {
        $shopSting->delete();
    }
}
