<?php

namespace App\Providers;


use Gate;
use App\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('superadmin', function ($user) {
           if(Auth::user()->role_id == 1){
               return true;
           }
           return false;
        });
        Gate::define('accounting', function ($user) {
            if(Auth::user()->role_id == 3){
                return true;
            }
            return false;
         });
    }
}
