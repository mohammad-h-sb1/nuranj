<?php

namespace App\Http\Controllers\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project=Project::all();
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
        //
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
        return response()->json([
            'status'=>'ok',
            'data'=>new ProjectResource($project)
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
        $project=Project::query()->where('id',$id)->first();
        $project->delete();
    }

    public function active()
    {
        $project=Project::query()->where('status',1)->get();
        $count=count($project);
        return response()->json([
            'status'=>'ok',
            'data'=>[
                'project'=>ProjectResource::collection($project),
                'count'=>$count
            ]
        ]);
    }

    public function website()
    {
        $project=Project::query()->where('website',1)->get();
        $count=count($project);
        $active=$project->where('status',1);
        $countActive=count($active);
        return response()->json([
            'status'=>'ok',
            'data'=>[
                'project'=>ProjectResource::collection($project),
                'count'=>$count,
                'countActive'=>$countActive
            ]
        ]);
    }public function application()
    {
        $project=Project::query()->where('application',1)->get();
        $count=count($project);
        $active=$project->where('status',1);
        $countActive=count($active);
        return response()->json([
            'status'=>'ok',
            'data'=>[
                'project'=>ProjectResource::collection($project),
                'count'=>$count,
                'countActive'=>$countActive
            ]
        ]);
    }
    public function startup()
    {
        $project=Project::query()->where('startup',1)->get();
        $count=count($project);
        $active=$project->where('status',1);
        $countActive=count($active);
        return response()->json([
            'status'=>'ok',
            'data'=>[
                'project'=>ProjectResource::collection($project),
                'count'=>$count,
                'countActive'=>$countActive]
        ]);
    }
    public function work_experience()
    {
        $project=Project::query()->where('work_experience',1)->get();
        $count=count($project);
        $active=$project->where('status',1);
        $countActive=count($active);
        return response()->json([
            'status'=>'ok',
            'data'=>[
                'project'=>ProjectResource::collection($project),
                'count'=>$count,
                'countActive'=>$countActive
            ]
        ]);
    }
    public function coding()
    {
        $project=Project::query()->where('coding',1)->get();
        $count=count($project);
        $active=$project->where('status',1);
        $countActive=count($active);
        return response()->json([
            'status'=>'ok',
            'data'=>[
                'project'=>ProjectResource::collection($project),
                'count'=>$count,
                'countActive'=>$countActive
            ]
        ]);
    }
    public function trade_relations()
    {
        $project=Project::query()->where('trade_relations',1)->get();
        $count=count($project);
        $active=$project->where('status',1);
        $countActive=count($active);
        return response()->json([
            'status'=>'ok',
            'data'=>[
                'project'=>ProjectResource::collection($project),
                'count'=>$count,
                'countActive'=>$countActive
            ]
        ]);
    }

    public function level(Request $request,$id)
    {
        $project=Project::query()->where('id',$id)->first();
        $project->update([
            'level'=>$request->level
        ]);
        dd($project);
    }

    public function status($id)
    {
        $project=Project::query()
            ->where('id',$id)
            ->where('level','test')
            ->first();
        $project->update([
            'status'=>!$project->status
        ]);

    }

    public function projectTeam(Request $request,$id)
    {
        $project=Project::query()->find($id);
        $project->workTeams()->sync($request->input('workTeams'));
        return response()->json([
            'status'=>'ok',
            'data'=>new ProjectResource($project)
        ]);
    }

}
