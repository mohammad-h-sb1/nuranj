<?php

namespace App\Http\Controllers\V2\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthGoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::query()->where('email', $googleUser->email)->first();
            if ($user) {
                $user->update([
                    'api_token' => Str::random(100)
                ]);
            }
            if ($user) {
                auth()->loginUsingId($user->id);
            } else {
//
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(Str::random(16)),
                    'api_token' => Str::random(100),
                ]);

            }
            return response()->json([
                'status' => 'ok',
                'data' => new UserResource($user)
            ]);
        } catch (\Exception $e) {
            //show error
            dd($e);
        };
    }

    public function logout()
    {
        $user = User::query()->where('id', auth()->user()->id);
        $user->update([
            'api_token' => null
        ]);
    }
}
