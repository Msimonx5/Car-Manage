<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AdminBSeeder::class,
            ClientSeeder::class,
            VehicleSeeder::class,
            ContractSeeder::class,
        ]);
    }
}