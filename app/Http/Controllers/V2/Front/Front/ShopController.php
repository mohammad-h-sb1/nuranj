<?php

namespace App\Http\Controllers\V2\Front\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\Front\ShopResource;
use App\Models\User;
use App\Models\V2\Permission;
use App\Models\V2\Product;
use App\Models\V2\Role;
use App\Models\V2\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop=Shop::query()->where('status',1)->where('expired_at','>',now())->paginate(\request('limit'));
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
            'name' => ['required','string','unique:shops','max:255'],
            'category_shop_id' => ['required'],
            'province_id' => ['required'],
            'city_id' => ['required'],
            'url' => ['required','unique:shops'],
            'phone' => ['required ','unique:shops','min:6','max:9'],
            'description'=>['string'],
        ]);
        $validData['expired_at']=Carbon::now()->addDays(14);
        $validData['user_id']=auth()->user()->id;
        User::query()->where('id',auth()->user()->id)->update([
            'type'=>'admin_shop'
        ]);
        $permissions=Permission::query()->where('type','admin_shop')->get();
        $roles=Role::query()->where('type','admin_shop')->get();
        auth()->user()->permissions()->sync($permissions);
        auth()->user()->roles()->sync($roles);
        $shop=Shop::create($validData);
        return  response()->json([
            'status'=>'ok',
            'data'=>new ShopResource($shop)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shop=Shop::query()->where('id',$id)->where('status',1)->where('expired_at','>',now())->first();
        return response()->json([
            'status'=>'ok',
            'data'=>new ShopResource($shop)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getShowProduct(Request $request)
    {
        $product=Product::query()->where('shop_id',$request->shop_id)->paginate(\request('limit'));
        return response()->json();
    }
}
