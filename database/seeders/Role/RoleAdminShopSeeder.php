<?php

namespace Database\Seeders\Role;

use App\Models\User;
use App\Models\V2\Role;
use Illuminate\Database\Seeder;

class RoleAdminShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Roles=[
            [
                'name'=>'admin_shop',
                'label'=>'ادمین شاپ',
                'type'=>'admin_shop',
            ]
        ];
        foreach ($Roles as $role){
            Role::updateOrCreate(
                ['name'=>$role['name'],'label'=>$role['label'],'type'=>$role['type']],
                ['label'=>$role['label'],'name'=>$role['name'],'type'=>$role['type']],
            );
        }
        $Roles=Role::query()->whereType('admin_shop')->first();
        $user=User::query()->whereType('admin_shop')->first();
        $user->roles()->sync($Roles);
    }
}
