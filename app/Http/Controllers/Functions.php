<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\V2\ActiveCode;
use App\Notifications\LoginUserNotification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Functions
{

    public static function storeTwoFactor($type,$userMobile,$mobile,$user)
    {
        if ($type == 'sms'){
            if ($userMobile!==$mobile){
                $code=ActiveCode::generateCode($user);
                //send sms
                $user->notify(new LoginUserNotification($code,$userMobile));
            }else{
                $user = User::query()->where('id', $user)->first();
                $user->update([
                    'two_factory_type' => 'sms'
                ]);
            }
        }
        if ($type == 'no') {
            $user = User::query()->where('id', $user)->first();
            $user->update([
                'two_factory_type' => 'of'
            ]);

        }

    }

    public static function send()
    {

    }
}
