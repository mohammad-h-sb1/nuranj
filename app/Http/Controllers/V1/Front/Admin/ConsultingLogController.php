<?php

namespace App\Http\Controllers\V1\Front\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\ConsultingLogResource;
use App\Models\ConsultingLog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultingLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consultingLog=ConsultingLog::query()->where('user_id',auth()->user()->id)->get();
        return response()->json([
            'status'=>'ok',
            'data'=>ConsultingLogResource::collection($consultingLog)
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
            'consulting_id'=>'required',
            'descriptions'=>'required'
        ]);
        $consultingLog=ConsultingLog::create([
            'user_id'=>auth()->user()->id,
            'consulting_id'=>$validData['consulting_id'],
            'descriptions'=>$validData['descriptions']
        ]);
        return response()->json([
            'status'=>'ok',
            'data'=>new ConsultingLogResource($consultingLog)
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
        $consultingLog=ConsultingLog::query()->where('id',$id)->first();
        if ($consultingLog->user_id == auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>new ConsultingLogResource($consultingLog)
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $consultingLog=ConsultingLog::query()->where('id',$id)->first();
        if ($consultingLog->user_id == auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>new ConsultingLogResource($consultingLog)
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $consultingLog=ConsultingLog::query()->where('id',$id)->first();
        if ($consultingLog->user_id == auth()->user()->id) {
            $consultingLog->update([
                'consulting_id'=>$request->consulting_id,
                'descriptions'=>$request->descriptions
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
