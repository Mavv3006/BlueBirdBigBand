<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Password;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        Password::defaults(function () {
            $rule = Password::min(8);

            return $this->app->isProduction()
                ? $rule->mixedCase()->numbers()->symbols()
                : $rule;
        });

        Gate::define('manage users', function (User $user) {
            return $user->hasPermissionTo('manage users');
        });
        Gate::define('manage roles', function (User $user) {
            return $user->hasPermissionTo('manage roles');
        });
        Gate::define('manage musicians', function (User $user) {
            return $user->hasPermissionTo('manage musicians');
        });
        Gate::define('manage songs', function (User $user) {
            return $user->hasPermissionTo('manage songs');
        });
        Gate::define('download songs', function (User $user) {
            return $user->hasPermissionTo('download songs', 'web');
        });
    }
}
