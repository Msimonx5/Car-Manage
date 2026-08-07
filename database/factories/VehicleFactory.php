<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\VehicleStatus;

class VehicleFactory extends Factory
{
    public function definition(): array
    {
        $brands = [

            'Dacia' => [
                'Logan',
                'Sandero',
                'Duster'
            ],

            'Renault' => [
                'Clio',
                'Megane'
            ],

            'Peugeot' => [
                '208',
                '308'
            ],

            'Toyota' => [
                'Yaris',
                'Corolla'
            ],

            'Hyundai' => [
                'i20',
                'Accent'
            ],

            'Kia' => [
                'Rio',
                'Picanto'
            ],

            'Volkswagen' => [
                'Polo',
                'Golf'
            ]

        ];

        $brand = fake()->randomElement(array_keys($brands));

        $model = fake()->randomElement($brands[$brand]);

        $km = fake()->numberBetween(10000, 220000);

        return [

            'marque' => $brand,

            'modele' => $model,

            'annee' => fake()->numberBetween(2018, 2025),

            'couleur' => fake()->randomElement([
                'Blanc',
                'Noir',
                'Gris',
                'Rouge',
                'Bleu'
            ]),

            'immatriculation' => fake()->unique()->bothify('#####-?-#'),

            'numero_chassis' => strtoupper(fake()->unique()->bothify('VF1###############')),

            'numero_moteur' => strtoupper(fake()->bothify('ENG########')),

            'carburant' => fake()->randomElement([
                'Essence',
                'Diesel',
                'Hybride'
            ]),

            'boite_vitesse' => fake()->randomElement([
                'Manuelle',
                'Automatique'
            ]),

            'nombre_places' => fake()->randomElement([
                4,
                5,
                7
            ]),

            'prix_jour' => fake()->numberBetween(250, 900),

            'caution' => fake()->numberBetween(3000, 12000),

            'kilometrage' => $km,

            'derniere_vidange_km' => $km - fake()->numberBetween(1000, 9000),

            'derniere_vidange_date' => fake()->dateTimeBetween(
                '-8 months',
                '-1 week'
            ),

            'prochaine_vidange_km' => $km + fake()->numberBetween(
                1000,
                10000
            ),

            'assurance_expiration' => fake()->dateTimeBetween(
                'now',
                '+1 year'
            ),

            'visite_technique' => fake()->dateTimeBetween(
                'now',
                '+1 year'
            ),

            'statut' => fake()->randomElement([
                VehicleStatus::DISPONIBLE,
                VehicleStatus::LOUE,
                VehicleStatus::MAINTENANCE,
                VehicleStatus::RESERVE
            ]),

            'observation' => fake()->optional()->sentence(),
        ];
    }
}