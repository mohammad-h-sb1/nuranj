<?php

namespace App\Http\Controllers\V1\Front\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\ConsultingResource;
use App\Models\Consulting;
use Illuminate\Http\Request;

class ConsultingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consulting=Consulting::query()->where('status',1)->get();
        return response()->json([
            'status'=>'ok',
            'data'=>ConsultingResource::collection($consulting)
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
        $consulting=Consulting::query()->where('id',$id)->first();
        if ($consulting->status == 1){
            return response()->json([
                'status'=>'ok',
                'data'=>new ConsultingResource($consulting)
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شمادست رسی ندارید'
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
