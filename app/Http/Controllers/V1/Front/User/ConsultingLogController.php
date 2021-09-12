<?php

namespace App\Http\Controllers\V1\Front\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\ConsultingLogResource;
use App\Models\ConsultingLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConsultingLogController extends Controller
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
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|digits:11|unique:users',
            'email' => '|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|',
            'consulting_id'=>'required',
            'descriptions'=>'required'
        ]);

        $user=User::create([
                'name'=>$validData['name'],
                'mobile'=>$validData['mobile'],
                'email'=>$validData['email'],
                'api_token'=>Str::random(100),
                'password'=>bcrypt($validData['password']),
        ]);
        $consultingLog=ConsultingLog::create([
            'user_id'=>$user->id,
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
     * @param  \App\Models\ConsultingLog  $consultingLog
     * @return \Illuminate\Http\Response
     */
    public function show(ConsultingLog $consultingLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ConsultingLog  $consultingLog
     * @return \Illuminate\Http\Response
     */
    public function edit(ConsultingLog $consultingLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ConsultingLog  $consultingLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConsultingLog $consultingLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ConsultingLog  $consultingLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConsultingLog $consultingLog)
    {
        //
    }
}
