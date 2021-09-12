<?php


use App\Http\Controllers\V2\Auth\AuthController;
use App\Http\Controllers\V2\Auth\AuthGoogleController;
use App\Http\Controllers\V2\Auth\PasswordController;
use App\Http\Controllers\V2\Dashboard\AdminShop\ProfileController as DashboardAdminShopProfile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V2\Front\Admin\ShopController as FrontAdminShop;

Route::middleware('auth:api')->group(function () {
    Route::prefix('dashboard')->group(function () {
        //admin

        //adminShop
        Route::prefix('admin/shop')->group(function (){
            //profile
            Route::prefix('profile')->group(function (){
                Route::get('/',[DashboardAdminShopProfile::class,'index']);


                //این روت های برای اینکه کاربر در پروفایلش بگه دوست داره دومرحله ای باشه یا نه
                Route::prefix('/two/factor')->group(function (){
                    //این روت برای ایجاد دومرحله میباشد
                    Route::post('create',[AuthController::class,'authenticated']);
                    Route::get('/',[DashboardAdminShopProfile::class,'twoFactor']);
                    Route::post('/store',[DashboardAdminShopProfile::class,'storeTwoFactor']);

//                Route::get('two/factor/mobile',[DashboardAdminShopProfile::class,'twoFactorMobile']);
                    Route::post('/mobile/store',[DashboardAdminShopProfile::class,'postTwoFactorMobile']);
                });

            });
        });
    });


    Route::post('v2/logout',[AuthController::class,'logout']);
    Route::get('/secret',[PasswordController::class,'password'])->middleware('password.confirm');
});


//روتهای که نیاز به توکن ندارد
Route::prefix('shop')->group(function () {
    Route::get('/', [FrontAdminShop::class, 'index']);
    Route::post('make', [FrontAdminShop::class, 'store']);
    Route::get('show/{url}', [FrontAdminShop::class, 'show']);
});

Route::get('auth/google',[AuthGoogleController::class,'redirect'])->middleware('web');
Route::get('auth/google/callback',[AuthGoogleController::class,'callback']);
Route::post('v2/register',[AuthController::class,'register']);
Route::post('v2/login',[AuthController::class,'login']);

