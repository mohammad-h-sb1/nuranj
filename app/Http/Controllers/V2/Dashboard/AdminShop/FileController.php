<?php

namespace App\Http\Controllers\V2\Dashboard\AdminShop;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AdminShop\FileResource;
use App\Http\Resources\V2\AdminShop\ProductResource;
use App\Models\V2\File;
use App\Models\V2\Product;
use App\Models\V2\Shop;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FileController extends Controller
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
    public function store(Request $request,Filesystem $filesystem)
    {
        $this->validate($request ,[
            'image' => 'required|file|mimes:jpeg,bmp,png,mp4,pdf|max:10240',
            'product_id'=>'required'
        ]);
        $file=$request->file('image');
        $year=Carbon::now()->year;
        $month=Carbon::now()->month;
        $day=Carbon::now()->day;
        $imagePath="/upload/image/{$year}/{$month}/{$day}";
        $extension = pathinfo(storage_path('/uploads/my_image.jpg'), PATHINFO_EXTENSION);
        $fileName=Str::random('11').".$extension";

        if ($filesystem->exists(public_path("{$imagePath}/{$fileName}"))){
            $fileName=Carbon::now()->timespan()."-{$fileName}";
        }
        $file->move(public_path($imagePath),$fileName);
        $shop=Shop::query()->where('user_id',auth()->user()->id)->pluck('id')->first();
        $product=Product::query()->where('id',$request->product_id)->first();
        $data=[
            'user_id'=>auth()->user()->id,
            'shop_id'=>$shop,
            'product_id'=>$request->input('product_id'),
            'url'=>url("$imagePath/$fileName")
        ];

        File::create($data);
        return response()->json([
            'status'=>'ok',
            'data'=>new ProductResource($product)
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        if ($file->user_id == auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>new FileResource($file)
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
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        if ($file->user_id == auth()->user()->id){
            $file->delete();
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دسترسی ندارید'
            ],403);

        }

    }
}
