<?php

namespace App\Http\Controllers\V1\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\ProfileResource;
use App\Models\Profile;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileController extends Controller
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
            'company' => '|string|unique:profiles',
            'address' => '|string|max:255|unique:profiles',
        ]);
        $profile=Profile::create([
            'user_id'=>auth()->user()->id,
            'name'=>auth()->user()->name,
            'company'=>$validData['company'],
            'address'=>$validData['address'],
            'type'=>auth()->user()->type,
        ]);
        return response()->json([
            'status'=>'ok',
            'data'=>new ProfileResource($profile)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        $project=Project::query()->where('user_id',auth()->user()->id)->get();
        $count=count($project);
        if ($profile->user_id == auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>[
                   'profile' =>new ProfileResource($profile),
                    'countProject'=>$count
                ]
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دسترسی ندرید'
            ],403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        $project=Project::query()->where('user_id',auth()->user()->id)->get();
        $count=count($project);
        if ($profile->user_id == auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>[
                    'profile' =>new ProfileResource($profile),
                    'countProject'=>$count
                ]
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دسترسی ندرید'
            ],403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        if ($profile->user_id == auth()->user()->id){
            $validData=$this->validate($request,[
                'company' => '|string|',
                'address' => '|string|max:255|',
            ]);
            $profile->update([
                'user_id'=>auth()->user()->id,
                'name'=>auth()->user()->name,
                'company'=>$validData['company'],
                'address'=>$validData['address'],
                'type'=>auth()->user()->type,
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دسترسی ندرید'
            ],403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
