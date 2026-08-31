<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [

            'type' => fake()->randomElement([
                'principal',
                'secondaire'
            ]),

            'nom' => fake()->lastName(),

            'prenom' => fake()->firstName(),

            'date_naissance' => fake()->dateTimeBetween(
                '-65 years',
                '-20 years'
            ),

            'lieu_naissance' => fake()->city(),

            'adresse' => fake()->address(),
            'ville' => fake()->city(),
            'code_postal' => fake()->postcode(),

            'cin' => strtoupper(fake()->unique()->bothify('??######')),

            'nationalite' => 'Marocaine',

            'numero_permis' => strtoupper(
                fake()->unique()->bothify('P########')
            ),

            'numero_passeport' => fake()->optional()->bothify(
                'PA#######'
            ),

            'adresse_etranger' => null,

            'telephone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}