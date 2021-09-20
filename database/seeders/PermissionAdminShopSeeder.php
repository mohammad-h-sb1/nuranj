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

            //adminShop stingShop
            [
                'name'=>'index_shop_sting_admin_shop',
                'label'=>'دیدن همه ستنیگ ها',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'shop_shop_sting_admin_shop',
                'label'=>'دیدن  ستنیگ',
                'type'=>'admin_shop'
            ],

            //adminShop Sting Shop type
            [
                'name'=>'index_shop_sting_type_admin_shop',
                'label'=>'دیدن همه ستینگ تایپ ها',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'store_shop_sting_type_admin_shop',
                'label'=>'ایجاد  ستینگ تایپ',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'show_shop_sting_type_admin_shop',
                'label'=>'دیدن یک  ستینگ تایپ',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'edit_shop_sting_type_admin_shop',
                'label'=>'ویرایش  ستینگ تایپ',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'update_shop_sting_type_admin_shop',
                'label'=>'اپدیت  ستینگ تایپ',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'delete_shop_sting_type_admin_shop',
                'label'=>'حذف  ستینگ تایپ',
                'type'=>'admin_shop'
            ],

            //adminShop sting Shop type meta
            [
                'name'=>'index_shop_sting_type_meta_value_admin_shop',
                'label'=>'دیدن همه ستینگ تایپ ولیو',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'store_shop_sting_type_meta_value_admin_shop',
                'label'=>'ایجاد ستینگ تایپ ولیو',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'show_shop_sting_type_meta_value_admin_shop',
                'label'=>'دیدن یک ستینگ تایپ ولیو',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'edit_shop_sting_type_meta_value_admin_shop',
                'label'=>'ویرایش ستینگ تایپ ولیو',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'update_shop_sting_type_meta_value_admin_shop',
                'label'=>'اپدیت ستینگ تایپ ولیو',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'delete_shop_sting_type_meta_value_admin_shop',
                'label'=>'حذف  ستینگ تایپ',
                'type'=>'admin_shop'
            ],

            //adminShop product
            [
                'name'=>'index_product_admin_shop',
                'label'=>'دیدن همه محصولات',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'store_product_admin_shop',
                'label'=>'ایجاد محصول',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'show_product_admin_shop',
                'label'=>'دیدن محصول',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'edit_product_admin_shop',
                'label'=>'ویرایش محصول',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'update_product_admin_shop',
                'label'=>'اپدیت محصول',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'delete_product_admin_shop',
                'label'=>'حذف  محصول',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'status_product_admin_shop',
                'label'=>' وضعیت محصول',
                'type'=>'admin_shop'
            ],

            //adminShop ProductMeta
            [
                'name'=>'index_product_meta_admin_shop',
                'label'=>'دیدن همه ویژگی محصولات',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'store_product_meta_admin_shop',
                'label'=>'ایجاد ویژگی محصول',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'show_product_meta_admin_shop',
                'label'=>'دیدن ویژگی محصول',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'edit_product_meta_admin_shop',
                'label'=>'ویرایش ویژگی محصول',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'update_product_meta_admin_shop',
                'label'=>'اپدیت ویژگی  محصول',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'delete_product_meta_admin_shop',
                'label'=>'حذف ویژگی محصول',
                'type'=>'admin_shop'
            ],

            //admin shop ticket
            [
                'name'=>'index_ticket_admin_shop',
                'label'=>'دیدن همه تیکت های محصولات',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'store_ticket_admin_shop',
                'label'=>'ایجاد تیکت محصول',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'show_ticket_admin_shop',
                'label'=>'دیدن تیکت محصول',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'edit_ticket_admin_shop',
                'label'=>'ویرایش تیکت محصول',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'update_ticket_admin_shop',
                'label'=>'اپدیت  تیکت محصول',
                'type'=>'admin_shop'
            ],
            [
                'name'=>'delete_ticket_admin_shop',
                'label'=>'حذف تیکت محصول',
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
