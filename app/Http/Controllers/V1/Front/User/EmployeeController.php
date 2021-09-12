<?php

namespace App\Http\Controllers\V1\Front\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\EmployeeResource;
use App\Http\Resources\User\UserResource;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
            'name' => 'required|string|',
            'family'=>'required|',
            'type'=>'required|',
            'mobile' => 'required|string|digits:11|unique:users',
            'email' => '|string|email|max:255|unique:users',
            'address'=>'required|',
            'gender'=>'required|',
            'marital_status'=>'required|',
            'age'=>'required|',
            'military_service_status'=>'required|',
            'password' => 'required|string|min:6|',

        ]);
        $user=User::create([
            'name'=>$validData['name'],
            'mobile'=>$validData['mobile'],
            'type'=>$validData['type'],
            'email'=>$validData['email'],
            'api_token'=>Str::random(100),
            'password'=>bcrypt($validData['password']),
        ]);
        $employee=Employee::create([
            'user_id'=>$user->id,
            'family'=>$validData['family'],
            'gender'=>$validData['gender'],
            'type'=>$validData['type'],
            'marital_status'=>$validData['marital_status'],
            'age'=>$validData['age'],
            'military_service_status'=>$validData['military_service_status'],
            'address'=>$validData['address'],
            'introduction_to'=>$request->introduction_to,
            'resume'=>$request->resume,
            'educational_background'=>$request->educational_background,
            'language'=>$request->language,
            'education_courses'=>$request->education_courses
        ]);

        return response()->json([
           'status'=>'ok',
           'data'=>new EmployeeResource($employee)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        if (auth()->user()->id == $employee->user_id){
            return response()->json([
                'status'=>'ok',
                'data'=>new EmployeeResource($employee)
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'manager'=>'شما دسترسی ندارید'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        if (auth()->user()->id == $employee->user_id){
            return response()->json([
                'status'=>'ok',
                'data'=>new EmployeeResource($employee)
            ]);
        }
        else{
            return response()->json([
               'status'=>'Error',
               'manager'=>'شما دسترسی ندارید'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        if (auth()->user()->id == $employee->user_id){
            $validData=$this->validate($request,[
                'name' => 'required|string|',
                'family'=>'required|',
                'type'=>'required|',
                'mobile' => 'required|string|digits:11|',
                'email' => '|string|email|max:255|',
                'address'=>'required|',
                'gender'=>'required|',
                'marital_status'=>'required|',
                'age'=>'required|',
                'military_service_status'=>'required|',
                'password' => 'required|string|min:6|',

            ]);
            $employee->update([
                'user_id'=>auth()->user()->id,
                'family'=>$validData['family'],
                'gender'=>$validData['gender'],
                'type'=>$validData['type'],
                'marital_status'=>$validData['marital_status'],
                'age'=>$validData['age'],
                'military_service_status'=>$validData['military_service_status'],
                'address'=>$validData['address'],
                'introduction_to'=>$request->introduction_to,
                'resume'=>$request->resume,
                'educational_background'=>$request->educational_background,
                'language'=>$request->language,
                'education_courses'=>$request->education_courses
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'manager'=>'شما دسترسی ندارید'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        if (auth()->user()->id == $employee->user_id){
            $employee->delete();
        }
        else{
            return response()->json([
                'status'=>'Error',
                'manager'=>'شما دسترسی ندارید'
            ]);
        }
    }

    public function intern()
    {
        $intern=Employee::query()->where('type','intern')->get();
        return response()->json([
           'status'=>'ok',
           'data'=>EmployeeResource::collection($intern)
        ]);
    }
}
