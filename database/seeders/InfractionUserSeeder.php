<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

/**
 * Compte de demonstration reserve au suivi des infractions.
 *
 * Il est rattache a une agence distincte et ne recoit jamais les permissions
 * liees aux contrats. Le document DA1 lui est donc servi automatiquement lors
 * de l'ouverture d'une infraction.
 */
class InfractionUserSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::firstOrCreate(
            ['slug' => 'agence-infractions'],
            ['name' => 'Agence Infractions']
        );

        $user = User::firstOrCreate(
            ['email' => 'infractions@location.ma'],
            [
                'tenant_id' => $tenant->id,
                'name' => 'Utilisateur infractions',
                'password' => Hash::make('infractions'),
            ]
        );

        // Le compte peut preexister : son agence et son role restent imposes.
        $user->forceFill(['tenant_id' => $tenant->id])->save();

        $role = Role::firstOrCreate([
            'name' => 'gestionnaire',
            'guard_name' => 'web',
        ]);

        $user->syncRoles([$role]);

        $this->command?->info("Compte infractions : {$user->email}");
    }
}
