<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
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

        // Manager
        $manager->syncPermissions([
            'dashboard.view',

            'clients.view',
            'clients.create',
            'clients.edit',

            'vehicles.view',
            'vehicles.create',
            'vehicles.edit',

            'contracts.view',
            'contracts.create',
            'contracts.edit',
            'contracts.download',
        ]);

        // Employee
        $employee->syncPermissions([
            'dashboard.view',

            'clients.view',
            'clients.create',
            'clients.edit',

            'vehicles.view',

            'contracts.view',
            'contracts.create',
            'contracts.download',
        ]);
    }
}