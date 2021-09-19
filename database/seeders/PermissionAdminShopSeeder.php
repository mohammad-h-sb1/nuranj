<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\V2\Permission;
use App\Models\V2\Role;
use Illuminate\Database\Seeder;

class PermissionAdminShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Permissions=[
            //adminShop show shop
            [
                'name'=>'show_shop_admin_shop',
                'label'=>'مشاهد_فروشگاه',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'edit_shop_admin_shop',
                'label'=>'ویرایش_فروشگاه',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'update_shop_admin_shop',
                'label'=>'ویرایش_فروشگاه',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'store_national_code_admin_shop',
                'label'=>'فرستادن عکس کارت شناسایی',
                'type'=>'admin_shop'
            ],

            //adminShop  shopCategory
            [
                'name'=>'index_shop_category_admin_shop',
                'label'=>'دیدن دسته بندی های فروشگاه',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'store_shop_category_admin_shop',
                'label'=>'ایجاد دسته بندی های فروشگاه',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'show_shop_category_admin_shop',
                'label'=>'دیدن یک دسته بندی های فروشگاه',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'edit_shop_category_admin_shop',
                'label'=>'ویرایش دسته بندی های فروشگاه',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'update_shop_category_admin_shop',
                'label'=>'اپدیت دسته بندی های فروشگاه',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'delete_shop_category_admin_shop',
                'label'=>'حذف دسته بندی های فروششگاه',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'status_shop_category_admin_shop',
                'label'=>'وضعیت دسته بندی های فروششگاه',
                'type'=>'admin_shop'
            ],

        ];
        foreach ($Permissions as $Permission){
            Permission::updateOrCreate(
                ['name'=>$Permission['name'],'label'=>$Permission['label'],'type'=>$Permission['type']],
                ['label'=>$Permission['label'],'name'=>$Permission['name'],'type'=>$Permission['type']],
            );
        }
        $Permissions=Permission::query()->whereType('admin_shop')->get();
        $user=User::query()->whereType('admin_shop')->first();
        $user->permissions()->sync($Permissions);
        $Role=Role::query()->whereType('admin_shop')->first();
        $Role->permissions()->sync($Permissions);
    }
}