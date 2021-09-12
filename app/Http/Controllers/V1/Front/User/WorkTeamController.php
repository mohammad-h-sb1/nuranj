<?php

namespace App\Http\Controllers\V1\Front\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\WorkTeamResource;
use App\Models\WorkTeam;
use Illuminate\Http\Request;

class WorkTeamController extends Controller
{
    public function index()
    {
        $workTeam=WorkTeam::all();
        return response()->json([
            'status'=>'ok',
            'data'=>WorkTeamResource::collection($workTeam)
        ]);
    }

    public function show($id)
    {
        $workTeam=WorkTeam::query()->where('id',$id)->first();
        return response()->json([
            'status'=>'ok',
            'data'=>new WorkTeamResource($workTeam)
        ]);
    }
}
