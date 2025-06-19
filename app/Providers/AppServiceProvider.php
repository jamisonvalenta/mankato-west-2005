<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('super-admin', function (User $user) {
            return $user->roles()->where('type', 'super-admin')->exists();
        });

        Gate::define('admin', function (User $user) {
            return $user->roles()->whereIn('type', ['super-admin', 'admin'])->exists();
        });

        Gate::define('verify', function (User $user) {
            return $user->roles()->whereIn('type', ['super-admin', 'verify'])->exists();
        });
    }
}
