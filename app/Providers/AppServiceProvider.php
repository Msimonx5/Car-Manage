<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Contract;

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

        View::composer('layouts.admin', function ($view): void {
            $user = Auth::user();
            $expiredContractCount = 0;
            $expiredContractNotifications = collect();

            if ($user && Gate::forUser($user)->allows('view-contracts')) {
                $sessionKey = 'read_expired_contract_ids.' . Auth::id();
                $legacyReadIds = session()->pull($sessionKey, []);

                if ($legacyReadIds !== []) {
                    $now = now();
                    $legacyReadRecords = array_map(
                        fn (int $contractId): array => [
                            'user_id' => Auth::id(),
                            'contract_id' => $contractId,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ],
                        array_values(array_unique(array_map('intval', $legacyReadIds)))
                    );

                    DB::table('contract_notification_reads')->insertOrIgnore($legacyReadRecords);
                }

                $readContractIds = DB::table('contract_notification_reads')
                    ->where('user_id', Auth::id())
                    ->pluck('contract_id')
                    ->all();
                $unreadContracts = Contract::query()->expired();

                if ($readContractIds !== []) {
                    $unreadContracts->whereNotIn('id', $readContractIds);
                }

                $expiredContractCount = (clone $unreadContracts)->count();
                $expiredContractNotifications = $unreadContracts
                    ->with(['client:id,nom,prenom'])
                    ->latest('date_retour')
                    ->latest('heure_retour')
                    ->limit(5)
                    ->get();
            }

            $view->with(compact(
                'expiredContractCount',
                'expiredContractNotifications'
            ));
        });

        Gate::before(function ($user, string $ability) {
            if (! $user) {
                return null;
            }

            if ($user->roles()->count() === 0) {
                $role = Role::firstOrCreate([
                    'name' => 'gestionnaire',
                    'guard_name' => 'web',
                ]);

                foreach ([
                    'dashboard.view',
                    'clients.view',
                    'vehicles.view',
                    'view-infractions',
                    'manage-infractions',
                ] as $permission) {
                    Permission::firstOrCreate(['name' => $permission]);
                }

                $role->syncPermissions([
                    'dashboard.view',
                    'clients.view',
                    'vehicles.view',
                    'view-infractions',
                    'manage-infractions',
                ]);

                $user->assignRole($role);
            }

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
