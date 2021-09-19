<?php

namespace App\Http\Controllers\V2\Dashboard\AdminShop;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AdminShop\ShopMetaResource;
use App\Models\V2\Shop;
use App\Models\V2\ShopMeta;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShopMetaController extends Controller
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
            'phone2' => ['min:7','max:9'],
            'shaba_number'=>['regex:/^(?:IR)(?=.{24}$)[0-9]*$/']
        ]);
        $shop=Shop::query()->where('user_id',auth()->user()->id)->pluck('id')->first();
        $data=[
            'shop_id'=>$shop,
            'user_id'=>auth()->user()->id,
            'phone2'=>$validData['phone2'],
            'instagram'=>$request->instagram,
            'telegram'=>$request->telegram,
            'shaba_number'=>$request->shaba_number
        ];
        $shopMeta=ShopMeta::create($data);
        return response()->json([
            'status'=>'ok',
            'data'=>new ShopMetaResource($shopMeta)
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShopMeta  $shopMeta
     * @return \Illuminate\Http\Response
     */
    public function show(ShopMeta $shopMeta)
    {
        return response()->json([
            'status'=>'ok',
            'data'=>new ShopMetaResource($shopMeta)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShopMeta  $shopMeta
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopMeta $shopMeta)
    {
        return response()->json([
            'status'=>'ok',
            'data'=>new ShopMetaResource($shopMeta)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShopMeta  $shopMeta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShopMeta $shopMeta)
    {
        $shopMeta->update([
            'user_id'=>auth()->user()->id,
            'phone2'=>$request['phone2'],
            'instagram'=>$request->instagram,
            'telegram'=>$request->telegram,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShopMeta  $shopMeta
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShopMeta $shopMeta)
    {
        $shopMeta->delete();
    }

    public function logo(ShopMeta $shopMeta,Filesystem $filesystem,Request $request)
    {
        $this->validate($request ,[
            'image' => 'required|file|mimes:jpeg,bmp,png,mp4,pdf|max:10240'
        ]);
        $shopMeta=ShopMeta::query()->where('user_id',\auth()->user()->id)->first();
        if ($shopMeta->user_id == auth()->user()->id){
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
            $shopMeta->update([
                'logo'=>url("$imagePath/$fileName")
            ]);
            return response()->json([
                'status'=>'ok',
                'data'=>new ShopMetaResource($shopMeta)
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دسترسی ندارید'
            ],403);
        }

    }

    public function favicon(Filesystem $filesystem,Request $request)
    {
        $this->validate($request ,[
            'image' => ['required','file','mimes:png','max:10240']
        ]);
        $shopMeta=ShopMeta::query()->where('user_id',\auth()->user()->id)->first();
        if ($shopMeta->user_id == auth()->user()->id){
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
            $shopMeta->update([
                'favicon'=>url("$imagePath/$fileName")
            ]);
            return response()->json([
                'status'=>'ok',
                'data'=>new ShopMetaResource($shopMeta)
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
