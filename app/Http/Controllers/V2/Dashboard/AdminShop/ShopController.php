<?php

namespace App\Http\Controllers\V2\Dashboard\AdminShop;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\V2\AdminShop\ShopResource;
use App\Models\V2\Shop;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $shop->expired_at);
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $shop->created_at);
        if ($shop->user_id == auth()->user()->id){
            return response()->json([
                'stata'=>'ok',
                'data'=>new ShopResource($shop),
                'diff_in_days'=>$to->diffInDays($from)
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دسترسی ندارید'
            ],401);
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

        if ($shop->user_id == auth()->user()->id){
            return response()->json([
                'stata'=>'ok',
                'data'=>new ShopResource($shop),
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دسترسی ندارید'
            ],401);
        }
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
        $validData=$this->validate($request,[
            'name' => ['required','string',Rule::unique('shops','name')->ignore($shop->id),'max:255'],
            'category_shop_id' => ['required'],
            'province_id' => ['required'],
            'city_id' => ['required'],
            'url' => ['required',Rule::unique('shops','url')->ignore($shop->id)],
            'phone' => ['required ',Rule::unique('shops','phone')->ignore($shop->id),'min:6','max:9'],
            'description'=>['string'],
            'national_code'=>['regex:"^(?!(\d)\1{9})\d{10}$"'],
        ]);
        $user=Auth::user();
        $user->update([
            'national_code'=>$validData['national_code'],
            'date_of_birth'=>$request->date_of_birth
        ]);
        $shop->update($validData);
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

    public function postNationalCode(Shop $shop,Filesystem $filesystem,Request $request)
    {
        if ($shop->user_id == auth()->user()->id){
            $this->validate($request ,[
                'image' => 'required|file|mimes:jpeg,bmp,png,mp4,pdf|max:10240'
            ]);
            $file=$request->file('image');
            $year=Carbon::now()->year;
            $month=Carbon::now()->month;
            $day=Carbon::now()->day;
            $imagePath="/upload/image/{$year}/{$month}/{$day}";
            $fileName=Str::random('11').".{$file->getMimeType()}";
            if ($filesystem->exists(public_path("{$imagePath}/{$fileName}"))){
                $fileName=Carbon::now()->timespan()."-{$fileName}";
            }
            $file->move(public_path($imagePath),$fileName);
            $user=Auth::user();
            $user->update([
                'national_code_img_url'=>url("$imagePath/$fileName")
            ]);
            return response()->json([
                'status'=>'ok',
                'data'=>new UserResource($user)
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
