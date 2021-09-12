<?php

namespace App\Http\Controllers\V2\Front\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\Front\ShopResource;
use App\Models\User;
use App\Models\V2\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop=Shop::query()->where('status',1)->paginate(5);
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
        $validData=$this->validate($request,[
            'url' => 'required|unique:shops',
            'password' => 'required',
            'mobile' => 'required|string|digits:11|unique:users',
        ]);

        $user=User::create([
            'mobile'=>$validData['mobile'],
            'api_token'=>Str::random(100),
            'password'=>bcrypt($validData['password']),
            'type'=>'admin_shop'
        ]);

        $shop=Shop::create([
            'user_id'=>$user->id,
            'url'=>$validData['url'],
            'password'=>bcrypt($validData['password']),
        ]);
        return response()->json([
            'status'=>'ok',
            'data'=>new ShopResource($shop)
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show($url)
    {
        $shop=Shop::query()->where('url',$url)->first();
        if (!empty($shop)){
            if ($shop->status == 1){
                return response()->json([
                    'status'=>'data',
                    'date'=>new ShopResource($shop)
                ]);
            }
            else{
                return response()->json([
                    'status'=>'Error',
                    'data'=>'شما دسترسی ندارید'
                ],403);
            }
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'یافت نشد'
            ],404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        //
    }
}
