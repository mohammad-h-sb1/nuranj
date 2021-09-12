<?php

namespace App\Http\Controllers\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProjectResource;
use App\Http\Resources\Admin\WorkTeamResource;
use App\Models\WorkTeam;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use phpDocumentor\Reflection\Project;

class WorkTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workTeam=WorkTeam::all();
        return response()->json([
            'status'=>'ok',
            'data'=>WorkTeamResource::collection($workTeam)
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
            'instagram' => 'string|unique:work_teams',
            'telegram' => '|string|max:255|unique:work_teams',
            'whatsapp' => '|string|max:255|unique:work_teams',
        ]);
        $workTeam=WorkTeam::create([
            'user_id'=>auth()->user()->id,
            'name'=>$validData['name'],
            'instagram'=>$validData['instagram'],
            'telegram'=>$validData['telegram'],
            'whatsapp'=>$validData['whatsapp'],
        ]);
        return response()->json([
            'status'=>'ok',
            'data'=>new WorkTeamResource($workTeam)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkTeam  $workTeam
     * @return \Illuminate\Http\Response
     */
    public function show(WorkTeam $workTeam)
    {
        return response()->json([
            'status'=>'ok',
            'data'=>new WorkTeamResource($workTeam)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkTeam  $workTeam
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkTeam $workTeam)
    {
        return response()->json([
            'status'=>'ok',
            'data'=>new WorkTeamResource($workTeam)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkTeam  $workTeam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkTeam $workTeam)
    {
        $validData=$this->validate($request,[
            'name' => 'required|string|max:255',
            'instagram' => 'string|',
            'telegram' => '|string|max:255|',
            'whatsapp' => '|string|max:255|',
        ]);
        $workTeam->update([
            'user_id'=>auth()->user()->id,
            'name'=>$validData['name'],
            'instagram'=>$validData['instagram'],
            'telegram'=>$validData['telegram'],
            'whatsapp'=>$validData['whatsapp'],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkTeam  $workTeam
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkTeam $workTeam)
    {
        $workTeam->delete();
    }


}
