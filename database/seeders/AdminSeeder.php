<?php

namespace Database\Seeders;

use App\Models\V2\Permission;
use App\Models\V2\Role;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Permissions=[
//            permission
            [
                'name'=>'create-permission',
                'label'=>'ایجاد دسترسی',
            ] ,
            [
                'name'=>'index-permission',
                'label'=>'مشاهده دسترسی ها',
                'type'=>'admin'
            ] ,
            [
                'name'=>'show-permission',
                'label'=>'مشاهده دسترسی',
                'type'=>'admin'

            ] ,
            [
                'name'=>'edit-permission',
                'label'=>'ویرایش دسترسی',
                'type'=>'admin'

            ] ,
            [
                'name'=>'update-permission',
                'label'=>'اپدیت دسترسی',
                'type'=>'admin'

            ] ,
            [
                'name'=>'delete-permission',
                'label'=>'پاک کردن دسترسی',
                'type'=>'admin'

            ] ,

            //role
            [
                'name'=>'create-role',
                'label'=>'ایجاد گروه دسترسی',
                'type'=>'admin'

            ] ,
            [
                'name'=>'index-role',
                'label'=>'مشاهده گروه دسترسی ها',
                'type'=>'admin'

            ] ,
            [
                'name'=>'show-role',
                'label'=>'مشاهده گروه دسترسی',
                'type'=>'admin'

            ] ,
            [
                'name'=>'edit-role',
                'label'=>'ویرایش گروه دسترسی',
                'type'=>'admin'

            ] ,
            [
                'name'=>'update-role',
                'label'=>'اپدیت گروه دسترسی',
                'type'=>'admin'

            ] ,
            [
                'name'=>'delete-role',
                'label'=>'پاک کردن گروه دسترسی',
                'type'=>'admin'

            ] ,

            //show permission user
            [
                'name'=>'show_permission_user',
                'label'=>'دیدن دسترسی های یوزر',
                'type'=>'admin'

            ] ,
            [
                'name'=>'create-permission-role',
                'label'=>'ایحاد دسترسی برای یوز',
                'type'=>'admin'

            ] ,

            //category Shop
            [
                'name'=>'index-category-shop',
                'label'=>'دیدن_دستبندی_فروشگاه_ها',
                'type'=>'admin'
            ] ,
            [
                'name'=>'store-category-shop',
                'label'=>'ایجاد_دستبندی_فروشگاه_ها',
                'type'=>'admin'
            ] ,
            [
                'name'=>'show-category-shop',
                'label'=>'دیدن_دستبندی_فروشگاه_ها',
                'type'=>'admin'
            ] ,
            [
                'name'=>'edit-category-shop',
                'label'=>'ویرایش_دستبندی_فروشگاه_ها',
                'type'=>'admin'
            ] ,
            [
                'name'=>'update-category-shop',
                'label'=>'اپدیت_دستبندی_فروشگاه_ها',
                'type'=>'admin'
            ] ,
            [
                'name'=>'delete-category-shop',
                'label'=>'حذف_دستبندی_فروشگاه_ها',
                'type'=>'admin'
            ] ,
            [
                'name'=>'status-category-shop',
                'label'=>'وضعیت_دستبندی_فروشگاه_ها',
                'type'=>'admin'
            ] ,

            //shop
            [
                'name'=>'index_shop',
                'label'=>'مشاهده_فروشگاه ها',
                'type'=>'admin'
            ],
            [
                'name'=>'show_shop',
                'label'=>'مشاهده_یک_فروشگاه',
                'type'=>'admin'
            ],
            [
                'name'=>'edit_shop',
                'label'=>'ویرایش_فروشگاه',
                'type'=>'admin'
            ],
            [
                'name'=>'update_shop',
                'label'=>'اپدیت_فروشگاه',
                'type'=>'admin'
            ],
            [
                'name'=>'delete_shop',
                'label'=>'حذف_فروشگاه',
                'type'=>'admin'
            ],
            [
                'name'=>'status_shop',
                'label'=>'وضعیت_یک_فروشگاه',
                'type'=>'admin'
            ],

            //admin stingShop
            [
                'name'=>'index_shop_sting_admin',
                'label'=>'دیدن همه ستینگ ها',
                'type'=>'admin'
            ],
            [
                'name'=>'store_shop_sting_admin',
                'label'=>'ایجاد ستینگ',
                'type'=>'admin'
            ],
            [
                'name'=>'show_shop_sting_admin',
                'label'=>'دیدن ستینگ',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'edit_shop_sting_admin',
                'label'=>'ویرایش ستینگ',
                'type'=>'admin'
            ],
            [
                'name'=>'update_shop_sting_admin',
                'label'=>'اپدیت ستینگ',
                'type'=>'admin'
            ],
            [
                'name'=>'delete_shop_sting_admin',
                'label'=>'حذف ستینگ',
                'type'=>'admin'
            ],


        ];
        foreach ($Permissions as $Permission){
            Permission::updateOrCreate(
                ['name'=>$Permission['name'],'label'=>$Permission['label'],],
                ['label'=>$Permission['label'],'name'=>$Permission['name'],],
            );
        }
        $Permissions=Permission::query()->whereType('admin')->get();
        $user=\App\Models\User::query()->where('type','admin')->first();
        $user->permissions()->sync($Permissions);
        $role=Role::query()->whereType('admin')->first();
        $role->permissions()->sync($Permissions);


    }
}
