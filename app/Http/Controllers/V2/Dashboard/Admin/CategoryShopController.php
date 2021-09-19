<?php

namespace App\Http\Controllers\V2\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\Admin\CategoryShopResource;
use App\Models\V2\CategoryShop;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\Rule;

class CategoryShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoryShop=CategoryShop::all();
        return response()->json([
            'status'=>'ok',
            'data'=>CategoryShopResource::collection($categoryShop)
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
            'name' => ['required','unique:category_shops','max:255'],
            'description' => ['string'],
        ]);
        $categoryShop=CategoryShop::create([
            'user_id'=>auth()->user()->id,
            'name'=>$validData['name'],
            'description'=>$validData['description']
        ]);
        return  response()->json([
            'status'=>'ok',
            'data'=>new CategoryShopResource($categoryShop)
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryShop  $categoryShop
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryShop $categoryShop)
    {
        return response()->json([
            'status'=>'ok',
            'data'=>[
                'category_shop'=>new CategoryShopResource($categoryShop),
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryShop  $categoryShop
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryShop $categoryShop)
    {

        return response()->json([
            'status'=>'ok',
            'data'=>[
                'category_shop'=>new CategoryShopResource($categoryShop),
                ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategoryShop  $categoryShop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoryShop $categoryShop)
    {
        $validData=$this->validate($request,[
            'name' => ['required',Rule::unique('category_shops','name')->ignore($categoryShop->id)],
            'description' => ['string'],
        ]);
        $categoryShop->update($validData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryShop  $categoryShop
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryShop $categoryShop)
    {
        $categoryShop->delete();
    }

    public function status($id)
    {
        $categoryShop=CategoryShop::query()->whereId($id)->first();
        $categoryShop->update([
                'status'=> !$categoryShop->status ,
            ]
        );
        return response()->json([
            'status'=>'ok',
            'data'=>new CategoryShopResource($categoryShop)
        ],201);
    }
}
