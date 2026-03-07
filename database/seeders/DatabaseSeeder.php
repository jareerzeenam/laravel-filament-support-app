<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Jareer Zeenam',
            'email' => 'jareer@email.com',
            'password' => bcrypt('123'),
        ]);

        Feature::factory(10)->create();
    }
}
