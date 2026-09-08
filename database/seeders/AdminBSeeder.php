<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

/**
 * Deuxieme agence avec son propre administrateur.
 *
 * Sert a verifier le cloisonnement des donnees : ce compte demarre sur un
 * espace vide, totalement separe de celui de SOULAMI CAR.
 *
 * Mot de passe volontairement simple : usage local uniquement, a changer
 * avant toute mise en ligne.
 */
class AdminBSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::firstOrCreate(
            ['slug' => 'agence-b'],
            ['name' => 'Agence B']
        );

        $admin = User::firstOrCreate(
            ['email' => 'adminb@location.ma'],
            [
                'tenant_id' => $tenant->id,
                'name' => 'Admin B',
                'password' => Hash::make('adminb'),
            ]
        );

        // Rattachement explicite : le compte peut preexister sans agence.
        if ($admin->tenant_id !== $tenant->id) {
            $admin->forceFill(['tenant_id' => $tenant->id])->save();
        }

        /*
         * Gestionnaire plutot qu'owner : ce compte administre son agence mais
         * n'a pas acces aux contrats. Le role peut ne pas exister sur une base
         * fraiche ; syncRoles corrige aussi un compte deja cree en owner.
         */
        $role = Role::firstOrCreate(['name' => 'gestionnaire', 'guard_name' => 'web']);

        $admin->syncRoles([$role]);

        $this->command?->info("Agence « {$tenant->name} » — admin {$admin->email}");
    }
}
