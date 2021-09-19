<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\V2\Permission;
use App\Models\V2\Role;
use Illuminate\Database\Seeder;

class PermissionCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Permissions=[
            [
                'name'=>'show-profile',
                'label'=>'مشاهد پروفایل',
                'type'=>'customer'
            ],

            //crate shop
            [
                'name'=>'store-shop',
                'label'=>'ایجاد_فروشگاه',
                'type'=>'customer'
            ]
        ];
        foreach ($Permissions as $Permission){
            Permission::updateOrCreate(
                ['name'=>$Permission['name'],'label'=>$Permission['label'],'type'=>$Permission['type']],
                ['label'=>$Permission['label'],'name'=>$Permission['name'],'type'=>$Permission['type']],
            );
        }
        $Permissions=Permission::query()->whereType('customer')->get();
        $user=User::query()->whereType('customer')->first();
        $user->permissions()->sync($Permissions);
        $Role=Role::query()->whereType('customer')->first();
        $Role->permissions()->sync($Permissions);
    }
}
