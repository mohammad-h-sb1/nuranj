<?php

namespace App\Http\Controllers\V2\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Functions;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Models\V2\ActiveCode;
use App\Models\V2\Permission;
use App\Models\V2\Role;
use App\Notifications\LoginToAppNotification;
use App\Notifications\LoginUserNotification;
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
            'mobile' => ['required','regex:/^(?:0|98|\+98|\+980|0098|098|00980)?(9\d{9})$/','unique:users'],
            'email' => 'required_unless:mobile,null|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|',
//            'g-recaptcha-response'=>['required',new Recaptcha()]
        ]);
        $role=Role::query()->whereType('customer')->get();
        $permission=Permission::query()->whereType('customer')->get();
        $user=User::create([
            'name'=>$validData['name'],
            'mobile'=>$validData['mobile'],
            'email'=>$validData['email'],
            'api_token'=>Str::random(100),
            'password'=>bcrypt($validData['password']),
        ]);
        $user->permissions()->sync($permission);
        $user->roles()->sync($role);

//        $role=Role::query()->where('')


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

    public function login(Request $request)
    {
        $validData=$this->validate($request,[
            'name' => 'required|string|',
            'password' => 'required|string|min:6|',
            'mobile' => ['required','regex:/^(?:0|98|\+98|\+980|0098|098|00980)?(9\d{9})$/','exists:users,mobile'],
        ]);

        $user=User::query()->whereMobile($validData['mobile'])->first();

        $code=ActiveCode::generateCode($user);
        $user->notify(new LoginUserNotification($code,$user->mobile));

        return  response()->json([
            'status'=>'ok',
            'data'=>'برای شما کد ارسال شد'
        ]);


//        if (! auth()->attempt($validData)){
//            return response()->json([
//                'status'=>'error',
//                'data'=>'اطلاعات صحیح نیست'
//            ],403);
//        }
//        if (auth()->user()->hasTwoFactorAuthEnable()){
//            $type=auth()->user()->type;
//            $userMobile=auth()->user()->mobile;
//            $mobile=$userMobile;
//            $user=auth()->user();
//            Functions::storeTwoFactor($type,$userMobile,$mobile,$user);
//            if (auth()->user()->email !==  null){
//                $user=auth()->user();
//                $user->notify(new LoginToAppNotification());
//            }
//        }
//
//        auth()->user()->update([
//            'api_token'=>Str::random(100)
//        ]);
//
//        return response()->json([
//            'status'=>'ok',
//            'data'=>auth()->user(),
//            'massage'=>'یک ایمبل برای شما ارسال شد'
//        ]);
    }

    public function getCode(Request $request)
    {
        $validData=$this->validate($request,[
            'code' => 'required',
            'mobile' => ['required','regex:/^(?:0|98|\+98|\+980|0098|098|00980)?(9\d{9})$/','exists:users,mobile'],
        ]);
        $user=User::query()->where('mobile',$validData['mobile'])->first();
        $status=ActiveCode::verifyCode($validData['code'],$user);
        if ($status){
            $user->update([
                'api_token'=>Str::random(100),
            ]);
            return response()->json([
                'status'=>'ok',
                'data'=>new UserResource($user),
                'massage'=>'شما لاگین شدید'
            ]);
        }
        else{
            return response()->json([
                'status'=>'error',
                'massage'=>'کد درست یست'
            ],401);
        }

    }

    public function logout()
    {
        $user = User::query()->where('id', auth()->user()->id);
        $user->update([
            'api_token' => null
        ]);
    }

}
