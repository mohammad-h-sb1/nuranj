<?php

namespace App\Http\Controllers\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee=Employee::query()->where('type','employee')->get();
        return response()->json([
            'status'=>'ok',
            'data'=>EmployeeResource::collection($employee)
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
        $employee=Employee::query()->where('id',$id)->first();
        return response()->json([
            'status'=>'ok',
            'data'=>new EmployeeResource($employee)
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
        $employee=Employee::query()->where('id',$id)->first();
        return response()->json([
            'status'=>'ok',
            'data'=>new EmployeeResource($employee)
        ]);
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
        $employee=Employee::query()->where('id',$id)->first();
        $employee->delete();
    }

    public function status($id)
    {
        $employee=Employee::query()->where('id',$id)->first();
        $employee->update([
            'status'=>!$employee->status
        ]);
    }

    public function intern()
    {
        $intern=Employee::query()->where('type','intern')->get();
        return response()->json([
            'status'=>'ok',
            'data'=>EmployeeResource::collection($intern)
        ]);
    }

    public function read()
    {
        $employee=Employee::query()->where('status',1)->get();
        return response()->json([
            'status'=>'ok',
            'data'=>EmployeeResource::collection($employee)
        ]);
    }

    public function unread()
    {
        $employee=Employee::query()->where('status',0)->get();
        return response()->json([
            'status'=>'ok',
            'data'=>EmployeeResource::collection($employee)
        ]);
    }
}
