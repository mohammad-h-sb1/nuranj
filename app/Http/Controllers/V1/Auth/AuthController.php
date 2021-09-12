<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Notifications\LoginUserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
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

//        $request->user()->notfiy(new LoginUserNotification());

        return response()->json([
            'status'=>'ok',
            'data'=>new UserResource($user)
        ]);
    }

    public function login(Request $request)
    {
        $validData=$this->validate($request,[
            'name' => 'required|string|',
            'password' => 'required|string|min:6|',
        ]);
        if (! auth()->attempt($validData)){
            return response()->json([
                'status'=>'error',
                'data'=>'اطلاعات صحیح نیست'
            ],403);
        }
        auth()->user()->update([
            'api_token'=>Str::random(100)
        ]);


        return response()->json([
            'status'=>'ok',
            'data'=>auth()->user()
        ]);
    }

    public function logout()
    {
        auth()->user()->update([
            'api_token'=>null
        ]);
        dd('yes');
    }
}
