<?php

namespace App\Providers;

use App\Policies\UserPolicy;
use App\User;
use Auth;
use Gravatar;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\SessionGuard;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('users.update', 'App\Policies\UserPolicy@update');

        SessionGuard::macro('nickname', function() {
            if (Auth::guest()) {
                return;
            }

            return Auth::user()->nickname;
        });

        SessionGuard::macro('gavatar', function() {
            if (Auth::guest()) {
                return;
            }

            return Gravatar::src(Auth::user()->email);
        });
    }
}
