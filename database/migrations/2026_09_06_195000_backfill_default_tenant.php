<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Rattache les donnees existantes a une agence.
 *
 * Sur une base qui contenait deja des donnees avant le cloisonnement, les
 * colonnes tenant_id ont ete ajoutees vides. Comme un compte sans agence ne
 * voit rien, l'application apparaissait vide alors que les donnees etaient
 * bien la. On regroupe donc tout l'existant sous une premiere agence.
 *
 * Sans donnees orphelines (installation neuve), la migration ne fait rien.
 */
return new class extends Migration
{
    private array $tables = ['clients', 'vehicles', 'contracts', 'payments', 'infractions'];

    public function up(): void
    {
        $orphanUsers = $this->orphanUserIds();

        if (! $this->hasOrphanRows() && $orphanUsers->isEmpty()) {
            return;
        }

        $tenantId = $this->defaultTenantId();

        foreach ($this->tables as $table) {
            if ($this->scopable($table)) {
                DB::table($table)->whereNull('tenant_id')->update(['tenant_id' => $tenantId]);
            }
        }

        if ($orphanUsers->isNotEmpty()) {
            DB::table('users')->whereIn('id', $orphanUsers)->update(['tenant_id' => $tenantId]);
        }
    }

    public function down(): void
    {
        // Un rattachement ne se defait pas : on ne saurait pas distinguer les
        // lignes rattachees ici de celles deja rattachees auparavant.
    }

    private function hasOrphanRows(): bool
    {
        foreach ($this->tables as $table) {
            if ($this->scopable($table) && DB::table($table)->whereNull('tenant_id')->exists()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Comptes sans agence, hors administrateurs de la plateforme : ces derniers
     * supervisent toutes les agences et doivent rester non rattaches.
     */
    private function orphanUserIds(): \Illuminate\Support\Collection
    {
        if (! $this->scopable('users')) {
            return collect();
        }

        $query = DB::table('users')->whereNull('tenant_id');

        if (Schema::hasTable('roles') && Schema::hasTable('model_has_roles')) {
            $platformAdmins = DB::table('model_has_roles')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('roles.name', 'platform-admin')
                ->pluck('model_has_roles.model_id');

            if ($platformAdmins->isNotEmpty()) {
                $query->whereNotIn('id', $platformAdmins);
            }
        }

        return $query->pluck('id');
    }

    private function defaultTenantId(): int
    {
        $existing = DB::table('tenants')->orderBy('id')->value('id');

        if ($existing !== null) {
            return (int) $existing;
        }

        // Nom neutre et previsible : APP_NAME vaut souvent encore « Laravel ».
        // A renommer depuis la table tenants une fois la migration passee.
        return DB::table('tenants')->insertGetId([
            'name' => 'Agence principale',
            'slug' => 'agence-principale',
            'next_contract_number' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function scopable(string $table): bool
    {
        return Schema::hasTable($table) && Schema::hasColumn($table, 'tenant_id');
    }
};
