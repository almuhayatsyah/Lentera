<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        // Use Bootstrap 5 pagination styling
        Paginator::useBootstrapFive();

        // Define admin gate
        Gate::define('admin', function (User $user) {
            return $user->isAdmin();
        });

        // Define kader gate
        Gate::define('kader', function (User $user) {
            return $user->isKader();
        });
    }
}
