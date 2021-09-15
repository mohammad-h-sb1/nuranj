<?php

namespace Database\Seeders;

use App\Models\V2\Role;
use Illuminate\Database\Seeder;

class RoleCustomerSeeder extends Seeder
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
                'name'=>'customer',
                'label'=>'یوزر مشتری',
                'type'=>'customer'
            ]
        ];
        foreach ($Roles as $role){
            Role::updateOrCreate(
                ['name'=>$role['name'],'label'=>$role['label'],'type'=>$role['type']],
                ['label'=>$role['label'],'name'=>$role['name'],'type'=>$role['type']],
            );
        }
        $Roles=Role::query()->whereType('customer')->first();
        $user=\App\Models\User::query()->whereType('customer')->first();
        $user->roles()->sync($Roles);

    }
}
