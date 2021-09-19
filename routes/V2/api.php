<?php


use App\Http\Controllers\V2\Auth\AuthController;
use App\Http\Controllers\V2\Auth\AuthGoogleController;
use App\Http\Controllers\V2\Auth\PasswordController;
use App\Http\Controllers\V2\Dashboard\Admin\CategoryShopController as DashboardAdminCategoryShop;
use App\Http\Controllers\V2\Dashboard\Admin\PermissionController as DashboardAdminPermission;
use App\Http\Controllers\V2\Dashboard\Admin\PermissionUserController as DashboardAdminPermissionUser;
use App\Http\Controllers\V2\Dashboard\Admin\RoleController as DashboardAdminRole;
use App\Http\Controllers\V2\Dashboard\AdminShop\ProductController as DashboardAdminShopProduct;
use App\Http\Controllers\V2\Dashboard\AdminShop\ShopCategoryController as DashboardAdminShopCategory;
use App\Http\Controllers\V2\Dashboard\AdminShop\ShopController as DashboardAdminShop;
use App\Http\Controllers\V2\Dashboard\AdminShop\ProfileController as DashboardAdminShopProfile;
use App\Http\Controllers\V2\Dashboard\AdminShop\ShopMetaController as DashboardAdminShopMetaShop;
use App\Http\Controllers\V2\Dashboard\Admin\ShopStingController as DashboardAdminShopSting;
use App\Http\Controllers\V2\Dashboard\AdminShop\ShopStingController;
use App\Http\Controllers\V2\Dashboard\AdminShop\ShopStingTypeController as DashboardAdminShopStingType;
use \App\Http\Controllers\V2\Dashboard\AdminShop\ShopStingMetaValueController as DashboardAdminShopStingTypeMetaValue;
use App\Http\Controllers\V2\Front\Front\ShopController;
use App\Http\Controllers\V2\Dashboard\Admin\ShopController as DashboardAdminShops;
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

            //shop
            Route::prefix('shop')->group(function (){
                Route::get('/',[DashboardAdminShops::class,'index'])->middleware('can:index_shop,user');
                Route::get('/show/{id}',[DashboardAdminShops::class,'show'])->middleware('can:show_shop,user');
                Route::get('/edit/{id}',[DashboardAdminShops::class,'edit'])->middleware('can:edit_shop,user');
                Route::put('/update/{id}',[DashboardAdminShops::class,'update'])->middleware('can:update_shop,user');
                Route::post('/status/{id}',[DashboardAdminShops::class,'status'])->middleware('can:status_shop,user');
            });

            Route::prefix('shop/sting')->group(function (){
                Route::get('/',[DashboardAdminShopSting::class,'index'])->middleware('can:index_shop_sting_admin,user');
                Route::post('/store',[DashboardAdminShopSting::class,'store'])->middleware('can:store_shop_sting_admin,user');
                Route::get('/show/{shopSting}',[DashboardAdminShopSting::class,'show'])->middleware('can:show_shop_sting_admin,user');
                Route::get('/edit/{shopSting}',[DashboardAdminShopSting::class,'edit'])->middleware('can:edit_shop_sting_admin,user');
                Route::put('/update/{shopSting}',[DashboardAdminShopSting::class,'update'])->middleware('can:delete_shop_sting_admin,user');
                Route::delete('/delete/{shopSting}',[DashboardAdminShopSting::class,'destroy'])->middleware('can:store_shop_sting_admin,user');
            });

        });
        //adminShop
        Route::prefix('admin/shop')->group(function (){
            //create shop
            Route::prefix('shop')->group(function (){
                Route::get('/show/{shop}',[DashboardAdminShop::class,'show'])->middleware('can:show_shop_admin_shop,user');
                Route::get('edit/{shop}',[DashboardAdminShop::class,'edit'])->middleware('can:edit_shop_admin_shop,user');
                Route::put('update/{shop}',[DashboardAdminShop::class,'update'])->middleware('can:update_shop_admin_shop,user');
                Route::post('post/national/code/shop/{shop}',[DashboardAdminShop::class,'postNationalCode'])->middleware('can:store_national_code_admin_shop,user');
            });
            //shop meta
            Route::prefix('shop/meta')->group(function (){
                Route::get('show/{shopMeta}',[DashboardAdminShopMetaShop::class,'show'])->middleware('can:show_shop_admin_shop,user');
                Route::post('store',[DashboardAdminShopMetaShop::class,'store'])->middleware('can:edit_shop_admin_shop,user');
                Route::get('edit/{shopMeta}',[DashboardAdminShopMetaShop::class,'edit'])->middleware('can:edit_shop_admin_shop,user');
                Route::put('update/{shopMeta}',[DashboardAdminShopMetaShop::class,'update'])->middleware('can:edit_shop_admin_shop,user');
                Route::post('logo/store/',[DashboardAdminShopMetaShop::class,'logo'])->middleware('can:edit_shop_admin_shop,user');
                Route::post('favicon/store/',[DashboardAdminShopMetaShop::class,'Favicon'])->middleware('can:edit_shop_admin_shop,user');
            });
            // shop category قسمت دسته بندی های هر شاپ
            Route::prefix('shop/category')->group(function (){
                Route::get('/',[DashboardAdminShopCategory::class,'index'])->middleware('can:index_shop_category_admin_shop,user');
                Route::post('/store',[DashboardAdminShopCategory::class,'store'])->middleware('can:store_shop_category_admin_shop,user');
                Route::get('/show/{shopCategory}',[DashboardAdminShopCategory::class,'show'])->middleware('can:show_shop_category_admin_shop,user');
                Route::get('/edit/{shopCategory}',[DashboardAdminShopCategory::class,'edit'])->middleware('can:edit_shop_category_admin_shop,user');
                Route::put('/update/{shopCategory}',[DashboardAdminShopCategory::class,'update'])->middleware('can:update_shop_category_admin_shop,user');
                Route::delete('/delete/{shopCategory}',[DashboardAdminShopCategory::class,'destroy'])->middleware('can:delete_shop_category_admin_shop,user');
                Route::post('/status/{id}',[DashboardAdminShopCategory::class,'status'])->middleware('can:status_shop_category_admin_shop,user');
                Route::post('/status/menu/{id}',[DashboardAdminShopCategory::class,'statusMenu'])->middleware('can:status_shop_category_admin_shop,user');
            });
            //shop sting
            Route::prefix('shop/sting')->group(function (){
                Route::get('/',[ShopStingController::class,'index'])->middleware('can:index_shop_sting_admin_shop,user');
                Route::get('/show/{id}',[ShopStingController::class,'show'])->middleware('can:shop_shop_sting_admin_shop,user');
            });
            //shop sting type
            Route::prefix('shop/sting/type')->group(function (){
                Route::get('/',[DashboardAdminShopStingType::class,'index'])->middleware('can:index_shop_sting_type_admin_shop,user');
                Route::post('/store',[DashboardAdminShopStingType::class,'store'])->middleware('can:store_shop_sting_type_admin_shop,user');
                Route::get('/show/{shopStingType}',[DashboardAdminShopStingType::class,'show'])->middleware('can:show_shop_sting_type_admin_shop,user');
                Route::get('/edit/{shopStingType}',[DashboardAdminShopStingType::class,'edit'])->middleware('can:edit_shop_sting_type_admin_shop,user');
                Route::put('/update/{shopStingType}',[DashboardAdminShopStingType::class,'update'])->middleware('can:update_shop_sting_type_admin_shop,user');
                Route::delete('/delete/{shopStingType}',[DashboardAdminShopStingType::class,'destroy'])->middleware('can:delete_shop_sting_type_admin_shop,user');
            });
            //shop sting type meta value
            Route::prefix('shop/sting/type/meta')->group(function (){
                Route::get('/',[DashboardAdminShopStingTypeMetaValue::class,'index'])->middleware('can:index_shop_sting_type_meta_value_admin_shop,user');
                Route::post('/store',[DashboardAdminShopStingTypeMetaValue::class,'store'])->middleware('can:store_shop_sting_type_meta_value_admin_shop,user');
                Route::get('/show/{shopStingMetaValue}',[DashboardAdminShopStingTypeMetaValue::class,'show'])->middleware('can:show_shop_sting_type_meta_value_admin_shop,user');
                Route::get('/edit/{shopStingMetaValue}',[DashboardAdminShopStingTypeMetaValue::class,'edit'])->middleware('can:edit_shop_sting_type_meta_value_admin_shop,user');
                Route::put('/update/{shopStingMetaValue}',[DashboardAdminShopStingTypeMetaValue::class,'update'])->middleware('can:update_shop_sting_type_meta_value_admin_shop,user');
                Route::delete('/delete/{shopStingMetaValue}',[DashboardAdminShopStingTypeMetaValue::class,'destroy'])->middleware('can:delete_shop_sting_type_meta_value_admin_shop,user');
            });

            //product
            Route::prefix('product')->group(function (){
                Route::get('/',[DashboardAdminShopProduct::class,'index'])->middleware('can:index_product_admin_shop,user');
                Route::post('/store',[DashboardAdminShopProduct::class,'store'])->middleware('can:store_product_admin_shop,user');
                Route::get('/show/{product}',[DashboardAdminShopProduct::class,'show'])->middleware('can:show_product_admin_shop,user');
                Route::get('/edit/{product}',[DashboardAdminShopProduct::class,'edit'])->middleware('can:edit_product_admin_shop,user');
                Route::put('/update/{id}',[DashboardAdminShopProduct::class,'update'])->middleware('can:update_product_admin_shop,user');
                Route::delete('/delete/{id}',[DashboardAdminShopProduct::class,'destroy'])->middleware('can:delete_product_admin_shop,user');
                Route::post('/status/{id}',[DashboardAdminShopProduct::class,'status'])->middleware('can:status_product_admin_shop,user');
            });

            //product meta



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

    Route::prefix('front')->group(function (){
        //shop
        Route::prefix('shop')->middleware('expired_at')->group(function (){
            Route::post('shop',[ShopController::class,'store'])->middleware('can:store-shop,user');
        });
    });


    Route::post('v2/logout',[AuthController::class,'logout']);

});
Route::prefix('shop')->group(function (){
    Route::get('/',[ShopController::class,'index']);
    Route::get('/show/{id}',[ShopController::class,'show'])->middleware('expired_at');
});



Route::get('auth/google',[AuthGoogleController::class,'redirect'])->middleware('web');
Route::get('auth/google/callback',[AuthGoogleController::class,'callback']);
Route::post('v2/register',[AuthController::class,'register']);
Route::post('v2/login',[AuthController::class,'login']);
Route::post('v2/get/code',[AuthController::class,'getCode']);

