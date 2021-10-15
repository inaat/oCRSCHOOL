<?php

namespace App\Providers;


use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->registerPolicies();

        // initialize passport routes
        Passport::routes();
        // Gate::before(function ($user, $ability) {
        //     return $user->hasRole('Admin') ? true : true;
        // });
        Gate::before(function ($user, $ability) {
            if (in_array($ability, ['backup', 'superadmin', 
                'manage_modules'])) {
                $administrator_list = config('constants.administrator_usernames');
            
                if (in_array($user->email, explode(',', $administrator_list))) {
                    return true;
                }
            } else {
                if ($user->hasRole('Admin#' . $user->system_settings_id)) {
                    return true;
                }
            }
        });
    }
}
