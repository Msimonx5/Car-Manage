<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Permissions verifiees par les routes.
     */
    private const PERMISSIONS_METIER = [
        'view-contracts',
        'create-contract',
        'edit-contract',
        'manage-clients',
        'manage-fleet',
        'view-fleet',
        'view-infractions',
        'manage-infractions',
    ];

    /**
     * Permissions liees aux contrats, retirees au role gestionnaire.
     */
    private const PERMISSIONS_CONTRATS = [
        'view-contracts',
        'create-contract',
        'edit-contract',

        // Anciens noms, presents sur certaines bases : retires eux aussi pour
        // que le role reste coherent quel que soit le vocabulaire employe.
        'contracts.view',
        'contracts.create',
        'contracts.edit',
        'contracts.delete',
        'contracts.download',
    ];

    public function run(): void
    {
        $permissions = [
            'dashboard.view',

            'clients.view',
            'clients.create',
            'clients.edit',
            'clients.delete',

            'vehicles.view',
            'vehicles.create',
            'vehicles.edit',
            'vehicles.delete',

            'contracts.view',
            'contracts.create',
            'contracts.edit',
            'contracts.delete',
            'contracts.download',

            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
        ];

        /*
         * Permissions reellement utilisees par l'application. Les noms
         * ci-dessus coexistent avec ceux-ci sur les bases existantes ; seuls
         * ceux de cette liste sont verifies par les routes.
         */
        $permissions = array_merge($permissions, self::PERMISSIONS_METIER);

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);
        }

        $admin = Role::firstOrCreate([
            'name' => 'admin',
        ]);

        $manager = Role::firstOrCreate([
            'name' => 'manager',
        ]);

        $employee = Role::firstOrCreate([
            'name' => 'employee',
        ]);

        /*
         * Roles du cloisonnement par agence : owner est attribue a chaque
         * administrateur d'agence a l'inscription, platform-admin donne une
         * vue sur toutes les agences.
         */
        $owner = Role::firstOrCreate([
            'name' => 'owner',
        ]);

        Role::firstOrCreate([
            'name' => 'platform-admin',
        ]);

        // Admin gets everything
        $admin->syncPermissions(Permission::all());

        // Owner : administrateur de sa propre agence
        $owner->syncPermissions(Permission::all());

        /*
         * Gestionnaire : gestion des infractions et consultation du tableau
         * de bord, des clients et des vehicules.
         */
        Role::firstOrCreate(['name' => 'gestionnaire'])
            ->syncPermissions([
                'dashboard.view',
                'clients.view',
                'vehicles.view',
                'view-contracts',
                'create-contract',
                'edit-contract',
                'view-infractions',
                'manage-infractions',
            ]);

        // Manager : gestion de son agence, sans consultation des contrats.
        $manager->syncPermissions([
            'dashboard.view',
            'view-contracts',

            'clients.view',
            'clients.create',
            'clients.edit',

            'vehicles.view',
            'vehicles.create',
            'vehicles.edit',
        ]);

        // Employee : aucune permission liee aux contrats non plus.
        $employee->syncPermissions([
            'dashboard.view',

            'clients.view',
            'clients.create',
            'clients.edit',

            'vehicles.view',
        ]);
    }
}
