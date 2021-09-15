<?php


use App\Http\Controllers\V2\Auth\AuthController;
use App\Http\Controllers\V2\Auth\AuthGoogleController;
use App\Http\Controllers\V2\Auth\PasswordController;
use App\Http\Controllers\V2\Dashboard\Admin\CategoryShopController as DashboardAdminCategoryShop;
use App\Http\Controllers\V2\Dashboard\Admin\PermissionController as DashboardAdminPermission;
use App\Http\Controllers\V2\Dashboard\Admin\PermissionUserController as DashboardAdminPermissionUser;
use App\Http\Controllers\V2\Dashboard\Admin\RoleController as DashboardAdminRole;
use App\Http\Controllers\V2\Dashboard\AdminShop\ProfileController as DashboardAdminShopProfile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::prefix('dashboard')->group(function () {
        //admin
        Route::prefix('admin')->group(function (){
            //دسترسی ها
            Route::prefix('permission')->group(function (){
                Route::get('/',[DashboardAdminPermission::class,'index'])->middleware('can:index-permission,user');
                Route::post('/store',[DashboardAdminPermission::class,'store'])->middleware('can:create-permission,user');
                Route::get('/show/{id}',[DashboardAdminPermission::class,'show'])->middleware('can:show-permission,user');
                Route::get('/edit{id}',[DashboardAdminPermission::class,'edit'])->middleware('can:edit-permission,user');
                Route::put('/update/{id}',[DashboardAdminPermission::class,'update'])->middleware('can:update-permission,user');
                Route::delete('/delete/{id}',[DashboardAdminPermission::class,'destroy'])->middleware('can:delete-permission,user');
            });
            //قسمت گروه دستبندی ها
            Route::prefix('role')->group(function (){
                Route::get('/',[DashboardAdminRole::class,'index'])->middleware('can:index-role,user');
                Route::post('/store',[DashboardAdminRole::class,'store'])->middleware('can:create-role,user');
                Route::get('/show/{id}',[DashboardAdminRole::class,'show'])->middleware('can:show-role,user');
                Route::get('/edit/{id}',[DashboardAdminRole::class,'edit'])->middleware('can:edit-role,user');
                Route::put('/update/{id}',[DashboardAdminRole::class,'update'])->middleware('can:update-role,user');
                Route::delete('/delete/{id}',[DashboardAdminRole::class,'destroy'])->middleware('can:delete-role,user');
            });
            //دسترسی یوزر
            Route::prefix('user/permission')->group(function (){
                Route::get('/{id}',[DashboardAdminPermissionUser::class,'show'])->middleware('can:show_permission_user,user');
                Route::post('/{id}/store',[DashboardAdminPermissionUser::class,'store'])->middleware('can:create_permission_user,user');
            });

            //category shops
            Route::prefix('category/shop')->group(function (){
                Route::get('/',[DashboardAdminCategoryShop::class,'index'])->middleware('can:index-category-shop,user');
                Route::post('/store',[DashboardAdminCategoryShop::class,'store'])->middleware('can:store-category-shop,user');
                Route::get('/show/{categoryShop}',[DashboardAdminCategoryShop::class,'show'])->middleware('can:show-category-shop,user');
                Route::get('/edit/{categoryShop}',[DashboardAdminCategoryShop::class,'edit'])->middleware('can:edit-category-shop,user');
                Route::put('/update/{categoryShop}',[DashboardAdminCategoryShop::class,'update'])->middleware('can:update-category-shop,user');
                Route::delete('/delete/{categoryShop}',[DashboardAdminCategoryShop::class,'destroy'])->middleware('can:delete-category-shop,user');
                Route::post('/status/{id}',[DashboardAdminCategoryShop::class,'status'])->middleware('can:status-category-shop,user');
            });
        });

        //adminShop
        Route::prefix('admin/shop')->group(function (){
            //profile
            Route::prefix('profile')->group(function (){
                Route::get('/',[DashboardAdminShopProfile::class,'index']);
                Route::get('show/{id}',[DashboardAdminShopProfile::class,'show'])->middleware('can:show-profile,user');

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



Route::get('auth/google',[AuthGoogleController::class,'redirect'])->middleware('web');
Route::get('auth/google/callback',[AuthGoogleController::class,'callback']);
Route::post('v2/register',[AuthController::class,'register']);
Route::post('v2/login',[AuthController::class,'login']);
Route::post('v2/get/code',[AuthController::class,'getCode']);

