<?php

namespace App\Http\Controllers\V2\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validData=$this->validate($request,[
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|digits:11|unique:users',
            'email' => 'required_unless:mobile,null|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|',
//            'g-recaptcha-response'=>['required',new Recaptcha()]
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


    public function authenticated(Request $request)
    {
        if (auth()->user()->two_factory_type == 'of'){
            auth()->user()->update([
                'two_factory_type'=>'sms'
            ]);
        }
        else{
            auth()->user()->update([
                'two_factory_type'=>'of'
            ]);
        }
    }
}