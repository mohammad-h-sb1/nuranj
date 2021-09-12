<?php

namespace App\Http\Controllers\V2\Dashboard\AdminShop;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Models\V2\ActiveCode;
use App\Notifications\LoginUserNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
            'mobile'=>['required_unless:type,no' ,Rule::unique('user','mobile')->ignore($request->user()->id)]
        ]);
        if ($validData['type'] == 'sms'){
            if ($request->user()->mobile !==$validData['mobile']){
                $code=ActiveCode::generateCode($request->user());
//                $request->session()->flash('mobile',$validData['mobile']);
                //send sms
                $request->user()->notify(new LoginUserNotification($code,$validData['mobile']));
            }else{
                $user = User::query()->where('id', auth()->user()->id)->first();
                $user->update([
                    'two_factory_type' => 'sms'
                ]);
            }
        }
        if ($validData['type'] == 'no') {
            $user = User::query()->where('id', auth()->user()->id)->first();
            $user->update([
                'two_factory_type' => 'of'
            ]);

        }
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
    {
        $validData = $this->validate($request, [
            'token' => 'required',
            'mobile' => 'required',
        ]);
//        if ($request->session()->has('mobile')){
//            dd('dcs');
//            return response()->json([
//                'status'=>'Error',
//                'massager'=>'شما دسترسی ندارید'
//            ],403);
//        }
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
