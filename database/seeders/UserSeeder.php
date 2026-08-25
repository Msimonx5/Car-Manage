<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Soulami',
            'email' => 'soulamimustafa74@gmail.com',
            'password' => bcrypt('soulami1974@@'),
        ]);
    }
}