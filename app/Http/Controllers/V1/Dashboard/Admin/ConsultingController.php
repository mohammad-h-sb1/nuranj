<?php

namespace App\Http\Controllers\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ConsultingResource;
use App\Models\Consulting;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consulting=Consulting::all();
        $active=$consulting->where('status',1);
        $inactive=$consulting->where('status',0);
        $count=count($consulting);
        $countActive=count($active);
        $countInactive=count($inactive);
        return response()->json([
            'status'=>'ok',
            'data'=>[
                'consulting'=>ConsultingResource::collection($consulting),
                'count'=>$count,
                'countActive'=>$countActive,
                'countInactive'=>$countInactive
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
            'name' => 'required|string|max:255|unique:consultings',
        ]);
        $consulting=Consulting::create([
            'user_id'=>auth()->user()->id,
            'name'=>$validData['name'],
            'status'=>1
        ]);
        return response()->json([
            'status'=>'ok',
            'data'=>new ConsultingResource($consulting)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consulting  $consulting
     * @return \Illuminate\Http\Response
     */
    public function show(Consulting $consulting)
    {
        return response()->json([
            'status'=>'ok',
            'data'=>new ConsultingResource($consulting)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consulting  $consulting
     * @return \Illuminate\Http\Response
     */
    public function edit(Consulting $consulting)
    {
        return response()->json([
            'status'=>'ok',
            'data'=>new ConsultingResource($consulting)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consulting  $consulting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consulting $consulting)
    {
        $validData=$this->validate($request,[
            'name' => 'required|string|max:255|',
        ]);
        $consulting->update([
            'name'=>$validData['name']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consulting  $consulting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consulting $consulting)
    {
        $consulting->delete();
    }

    public function status($id)
    {
        $consulting=Consulting::query()->where('id',$id)->first();
        $consulting->update([
            'status'=>!$consulting->status,
        ]);
    }
}
