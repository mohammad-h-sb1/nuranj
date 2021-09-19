<?php

namespace Database\Seeders\Role;

use App\Models\V2\Role;
use Illuminate\Database\Seeder;

class RoleAdminSeeder extends Seeder
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
                'name'=>'admin',
                'label'=>'یوزر ادمین'
            ]
        ];
        foreach ($Roles as $role){
            Role::updateOrCreate(
                ['name'=>$role['name'],'label'=>$role['label']],
                ['label'=>$role['label'],'name'=>$role['name']],
            );
        }
        $Roles=Role::query()->whereType('admin')->first();
        $user=\App\Models\User::query()->whereType('admin')->first();
        $user->roles()->sync($Roles);
    }
}
