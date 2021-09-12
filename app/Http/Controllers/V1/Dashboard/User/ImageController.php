<?php

namespace App\Http\Controllers\V1\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\ImageResource;
use App\Models\Image;
use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageController extends Controller
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
        $profile=Profile::query()->where('user_id',auth()->user()->id)->pluck('id')->first();
        $this->validate($request ,[
            'image' => 'required|mimes:jpeg,bmp,png,|max:10240'
        ]);
        $file=$request->file('image');
        $year=Carbon::now()->year;
        $month=Carbon::now()->month;
        $day=Carbon::now()->day;
        $imagePath="/upload/image/{$year}/{$month}/{$day}";
        $fileName=$file->getClientOriginalName();
        if ($filesystem->exists(public_path("{$imagePath}/{$fileName}"))){
            $fileName=Carbon::now()->timespan()."-{$fileName}";
        }

        $file->move(public_path($imagePath) , $fileName);
        $data=[
            'user_id'=>auth()->user()->id,
            'pro_id'=>$profile,
            'url'=>url("{$imagePath}/{$fileName}"),
            'status'=>1
        ];
        $a=Image::create($data);
        return response([
            'status"ok',
            'data'=>[
                'collection'=>new ImageResource($a),
                'image'=>url("{$imagePath}/{$fileName}",),
            ],
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
//        $profile=Profile::query()->where('id',$id)->first();
//        if ($profile->user_id === auth()->user()->id){
//          $img=Image::query()->where('pro_id',$profile->id)->first();
//          return response()->json('')
//        }
//        else{
//
//        }
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
}
