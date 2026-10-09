<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;

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
        Paginator::useBootstrapFive();

        Gate::before(function ($user, string $ability) {
            if ($user->hasAnyRole(['owner', 'admin'])) {
                return match ($ability) {
                    'view-infractions', 'manage-infractions' => true,
                    default => null,
                };
            }

            if (! $user->hasRole('gestionnaire')) {
                return null;
            }

            return match ($ability) {
                'view-infractions' => true,
                'manage-infractions' => true,
                'dashboard.view', 'clients.view', 'vehicles.view' => true,
                'clients.create', 'clients.edit', 'clients.delete',
                'vehicles.create', 'vehicles.edit', 'vehicles.delete' => false,
                default => null,
            };
        });
    }
}
