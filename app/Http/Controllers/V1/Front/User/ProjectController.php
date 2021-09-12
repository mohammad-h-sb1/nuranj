<?php

namespace App\Http\Controllers\V1\Front\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\ProjectResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project=Project::query()->where('status',1)->get();
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
        $validData=$this->validate($request,[
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|digits:11|unique:users',
            'email' => '|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|',
        ]);
        $user=User::create([
            'name'=>$validData['name'],
            'mobile'=>$validData['mobile'],
            'email'=>$validData['email'],
            'api_token'=>Str::random(100),
            'password'=>bcrypt($validData['password']),
        ]);

        $project=Project::create([
            'user_id'=>$user->id,
            'company'=>$request->company,
            'website'=>$request->website,
            'application'=>$request->application,
            'startup'=>$request->startup,
            'work_experience'=>$request->work_experience,
            'coding'=>$request->coding,
            'trade_relations'=>$request->trade_relations,
            'description'=>$request->description,
            'category_id'=>$request->category_id,
        ]);
        return response()->json([
            'status'=>'ok',
            'data'=>new ProjectResource($project)
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        if ($project->status === 1){
            return response()->json([
                'status'=>'ok',
                'data'=>new ProjectResource($project)
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دسنرسی ندارید'
            ],403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
