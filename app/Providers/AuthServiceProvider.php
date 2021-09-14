<?php

namespace App\Providers;

use App\Models\Profile;
use App\Models\V2\Permission;
use App\Policies\ProfilePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//         'App\Models\Model' => 'App\Policies\ModelPolicy',
//         Profile::class=>ProfilePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        foreach (Permission::all() as $permission){
            Gate::define($permission->name,function ($user) use ($permission){
                return $user->hasPermission($permission);
            });
        }

    }
}
