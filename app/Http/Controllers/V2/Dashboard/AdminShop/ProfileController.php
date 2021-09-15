<?php

namespace App\Http\Controllers\V2\Dashboard\AdminShop;

use App\Container;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Functions;
use App\Http\Resources\User\ProfileResource;
use App\Http\Resources\User\UserResource;
use App\Models\Profile;
use App\Models\User;
use App\Models\V2\ActiveCode;
use App\Notifications\LoginUserNotification;
use App\Services\FooService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{

    public function __construct()
    {
//        $this->middleware('can:edit-profile-shop,user')->only(['edit']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fooService=new FooService();
        $fooService->dsSomething();
        $container=new Container();
        $container->bind('fooService',function (){
            return new FooService();
        });
        dd($container->resolve('fooService'));
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
       $profile=Profile::query()->whereId($id)->first();
       return response()->json([
           'status'=>'ok',
           'data'=>new ProfileResource($profile)
       ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $profile=Profile::query()->where('id',$id)->where('user_id',auth()->user()->id)->first();
        $auth=$this->authorize('edit-profile-shop',$profile);
        if ($auth){
            return response()->json([
                'status'=>'ok',
                'data'=>new ProfileResource($profile)
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massager'=>'شما دستریسی ندارید'
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

    public function twoFactor()
    {

    }

    public function getMobileVerify(Request $request)
    {
        if ($request->session()->has('mobile')){
            return response()->json([
                'status'=>'Error',
                'massager'=>'شما دسترسی ندارید'
            ],403);
        }
        $request->session()->reflash();
    }

    public function storeTwoFactor(Request $request)
    {
        $validData = $this->validate($request, [
            'type' => 'required|in:sms,no',
            'mobile'=>['required_unless:type,no' ,Rule::unique('users','mobile')->ignore($request->user()->id)]
        ]);
        $type=$validData['type'];
        $userMobile=\auth()->user()->mobile;
        $user=\auth()->user();
        $mobile=$validData['mobile'];
        Functions::storeTwoFactor($type,$userMobile,$mobile,$user,);
        return response()->json([
            'status' => 'ok',
            'data' => [
                'user'=>new UserResource($request->user()),
            ]
        ]);
    }

//    public function twoFactorMobile()
//    {
//
//    }

    public function postTwoFactorMobile(Request $request)
    {;
        $validData = $this->validate($request, [
            'token' => 'required',
            'mobile' => 'required',
        ]);

        $status=ActiveCode::verifyCode($request->token,auth()->user());
        if ($status){
            $request->user()->activeCode()->delete();
            $request->user()->update([
                'two_factory_type'=>'sms',
                'mobile'=>$request->mobile
            ]);
            return response()->json([
                'status'=>'ok',
                'data'=>'ورود دو مرحله ای شما انجام شد'
            ]);
        }else{
            return response()->json([
                'status'=>'Error',
                'massager'=>'کد درست نیست'
            ],403);
        }
    }
}
