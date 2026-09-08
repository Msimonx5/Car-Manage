<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Concerns\SeedsForTenant;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    use SeedsForTenant;

    public function run(): void
    {
        // Rattache a l'agence des donnees de demonstration, sinon le compte
        // se connecte sur une application vide.
        $user = User::factory()->create([
            'tenant_id' => $this->tenantId(),
            'name' => 'admin',
            'email' => 'admin@location.com',
            'password' => bcrypt('admin'),
        ]);

        $user->assignRole(Role::firstOrCreate(['name' => 'owner', 'guard_name' => 'web']));
    }
}