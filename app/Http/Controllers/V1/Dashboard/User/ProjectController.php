<?php

namespace App\Http\Controllers\V1\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project=Project::query()->where('user_id',auth()->user()->id)->get();
        return response()->json([
            'status'=>'ok',
            'data'=>ProjectResource::collection($project)
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

        $data=[
            'user_id'=>auth()->user()->id,
            'company'=>$request->company,
            'website'=>$request->website,
            'application'=>$request->application,
            'startup'=>$request->startup,
            'work_experience'=>$request->work_experience,
            'coding'=>$request->coding,
            'trade_relations'=>$request->trade_relations,
            'description'=>$request->description,
            'category_id'=>$request->category_id,
            ];
        $project=Project::create($data);
        return response()->json([
            'status'=>'ok',
            'data'=>new ProjectResource($project)
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
        $project=Project::query()->where('id',$id)->first();
        if ($project->user_id == auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>new ProjectResource($project)
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دسترسی ندارید'
            ]);
        }
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
