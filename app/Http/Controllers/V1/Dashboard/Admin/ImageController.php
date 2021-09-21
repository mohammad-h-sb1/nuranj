<?php

namespace App\Http\Controllers\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ImageResource;
use App\Models\Image;
use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $img=Image::all();
        $count=count($img);
        return response()->json([
            'status'=>'ok',
            'data'=>[
                'img'=>ImageResource::collection($img),
                'count'=>$count
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            'image' => 'required|file|mimes:jpg,bmp,png,mp4,pdf|max:10240'
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
            'project_id'=>$request->project_id,
            'pro_id'=>$request->profile_id,
            'work_team_id'=>$request->work_team_id,
            'url'=>url("{$imagePath}/{$fileName}"),
            'page_id'=>$request->page_id,
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
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        return response()->json([
            'status'=>'ok',
            'data'=>new ImageResource($image)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        $image->delete();
    }

    public function status($id)
    {
        $image=Image::query()->where('id',$id)->first();
        $image->update([
            'status'=>! $image->status
        ]);
    }
}
