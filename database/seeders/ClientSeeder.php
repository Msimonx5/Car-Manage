<?php

namespace Database\Seeders;

use App\Models\Client;
use Database\Seeders\Concerns\SeedsForTenant;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    use SeedsForTenant;

    public function run(): void
    {
        Client::factory()
            ->count(50)
            ->create(['tenant_id' => $this->tenantId()]);
    }
}