<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Database\Seeders\Concerns\SeedsForTenant;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    use SeedsForTenant;

    public function run(): void
    {
        Vehicle::factory()
            ->count(30)
            ->create(['tenant_id' => $this->tenantId()]);
    }
}
