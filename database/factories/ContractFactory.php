<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Contract;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ContractStatus;

class ContractFactory extends Factory
{
    protected $model = Contract::class;

    public function definition(): array
    {
        $dateDepart = fake()->dateTimeBetween('-6 months', '+1 month');

        $nombreJours = fake()->numberBetween(1, 15);

        $dateRetour = (clone $dateDepart)->modify("+{$nombreJours} days");

        $vehicle = Vehicle::inRandomOrder()->first();

        $tarifJour = $vehicle?->prix_jour ?? fake()->numberBetween(250, 800);

        $totalHT = $tarifJour * $nombreJours;

        $tva = round($totalHT * 0.20, 2);

        $totalTTC = $totalHT + $tva;

        $kmDepart = $vehicle?->kilometrage ?? fake()->numberBetween(10000, 150000);

        $kmRetour = fake()->boolean(70)
            ? $kmDepart + fake()->numberBetween(50, 1200)
            : null;

        return [

            'numero' => 'CTR-' . fake()->unique()->numerify('######'),

            'client_id' => Client::inRandomOrder()->value('id'),

            'vehicle_id' => $vehicle?->id,

            'second_driver_id' => fake()->boolean(25)
                ? Client::inRandomOrder()->value('id')
                : null,

            'date_depart' => $dateDepart->format('Y-m-d'),

            'heure_depart' => fake()->randomElement([
                '08:00:00',
                '09:00:00',
                '10:00:00',
                '14:00:00',
                '16:00:00'
            ]),

            'date_retour' => $dateRetour->format('Y-m-d'),

            'heure_retour' => fake()->randomElement([
                '08:00:00',
                '09:00:00',
                '10:00:00',
                '14:00:00',
                '16:00:00'
            ]),

            'km_depart' => $kmDepart,

            'km_retour' => $kmRetour,

            'tarif_jour' => $tarifJour,

            'nombre_jours' => $nombreJours,

            'avance' => fake()->randomFloat(
                2,
                0,
                $totalHT * 0.5
            ),

            'caution' => $vehicle?->caution ?? fake()->numberBetween(3000, 8000),

            'total_ht' => $totalHT,

            'tva' => $tva,

            'total_ttc' => $totalTTC,

            'mode_paiement' => fake()->randomElement([
                'Espèces',
                'Carte bancaire',
                'Virement'
            ]),

            'statut' => fake()->randomElement([
                ContractStatus::EN_ATTENTE,
                ContractStatus::EN_COURS,
                ContractStatus::TERMINE,
                ContractStatus::ANNULE,
            ]),

            'observation' => fake()->optional()->sentence(),
        ];
    }
}