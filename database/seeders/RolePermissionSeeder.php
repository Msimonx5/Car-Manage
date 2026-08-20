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

        // Admin gets everything
        $admin->syncPermissions(Permission::all());

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