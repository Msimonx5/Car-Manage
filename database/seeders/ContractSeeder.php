<?php

namespace Database\Seeders;

use App\Enums\VehicleStatus;
use App\Models\Contract;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Génère des contrats à partir des clients et véhicules déjà créés.
        Contract::factory()
            ->count(40)
            ->create();

        // Les véhicules ayant un contrat "en cours" passent au statut "loué",
        // pour rester cohérent avec le tableau de bord.
        $vehiculesLoues = Contract::where('statut', 'en_cours')
            ->pluck('vehicle_id')
            ->unique();

        Vehicle::whereIn('id', $vehiculesLoues)
            ->update(['statut' => VehicleStatus::LOUE->value]);
    }
}
