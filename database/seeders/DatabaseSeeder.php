<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Les comptes crees par les seeders ont besoin de ces roles et
            // permissions. Cet ordre garantit notamment que l'owner de
            // l'agence principale peut consulter les contrats.
            RolePermissionSeeder::class,
            UserSeeder::class,
            AdminBSeeder::class,
            InfractionUserSeeder::class,
            ClientSeeder::class,
            VehicleSeeder::class,
            ContractSeeder::class,
        ]);
    }
}
