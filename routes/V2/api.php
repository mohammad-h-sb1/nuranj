<?php


use App\Http\Controllers\V2\Auth\AuthController;
use App\Http\Controllers\V2\Auth\AuthGoogleController;
use App\Http\Controllers\V2\Auth\PasswordController;
use App\Http\Controllers\V2\Dashboard\Admin\PermissionController as DashboardAdminPermission;
use App\Http\Controllers\V2\Dashboard\Admin\PermissionUserController as DashboardAdminPermissionUser;
use App\Http\Controllers\V2\Dashboard\Admin\RoleController as DashboardAdminRole;
use App\Http\Controllers\V2\Dashboard\AdminShop\ProfileController as DashboardAdminShopProfile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V2\Front\Admin\ShopController as FrontAdminShop;

Route::middleware('auth:api')->group(function () {
    Route::prefix('dashboard')->group(function () {
        //admin
        Route::prefix('admin')->group(function (){
            //دسترسی ها
            Route::prefix('permission')->group(function (){
                Route::get('/',[DashboardAdminPermission::class,'index'])->middleware('admin');
                Route::post('/store',[DashboardAdminPermission::class,'store'])->middleware('admin');
                Route::get('/show/{id}',[DashboardAdminPermission::class,'show'])->middleware('admin');
                Route::get('/edit{id}',[DashboardAdminPermission::class,'edit'])->middleware('admin');
                Route::put('/update/{id}',[DashboardAdminPermission::class,'update'])->middleware('admin');
                Route::delete('/delete/{id}',[DashboardAdminPermission::class,'destroy'])->middleware('admin');
            });
            //قسمت گروهدست بندی ها
            Route::prefix('role')->group(function (){
                Route::get('/',[DashboardAdminRole::class,'index'])->middleware('admin');
                Route::post('/store',[DashboardAdminRole::class,'store'])->middleware('admin');
                Route::get('/show/{id}',[DashboardAdminRole::class,'show'])->middleware('admin');
                Route::get('/edit/{id}',[DashboardAdminRole::class,'edit'])->middleware('admin');
                Route::put('/update/{id}',[DashboardAdminRole::class,'update'])->middleware('admin');
                Route::delete('/delete/{id}',[DashboardAdminRole::class,'destroy'])->middleware('admin');
            });
            //دسترسی یوزر
            Route::prefix('user/permission')->group(function (){
                Route::get('/{id}',[DashboardAdminPermissionUser::class,'show']);
                Route::post('/{id}/store',[DashboardAdminPermissionUser::class,'store']);
            });
        });

        //adminShop
        Route::prefix('admin/shop')->group(function (){
            //profile
            Route::prefix('profile')->group(function (){
                Route::get('/',[DashboardAdminShopProfile::class,'index']);
                Route::get('edit/{id}',[DashboardAdminShopProfile::class,'edit'])->middleware('can:edit-profile-shop,user');

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

