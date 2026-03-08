<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Feature;
use App\Models\Milestone;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(50)->create();

        User::factory()->create([
            'name' => 'Jareer Zeenam',
            'email' => 'jareer@email.com',
            'password' => bcrypt('123'),
            'is_admin' => true,
        ]);

        Feature::factory(10)->create();
        Milestone::factory(20)->create([
            'feature_id' => function () {
                return Feature::inRandomOrder()->first()->id;
            },
        ]);

        Comment::factory(20)->create(
            [
                'feature_id' => function () {
                    return Feature::inRandomOrder()->first()->id;
                },
                'user_id' => function () {
                    return User::inRandomOrder()->first()->id;
                },
            ]
        );
        Vote::factory(20)->create(
            [
                'feature_id' => function () {
                    return Feature::inRandomOrder()->first()->id;
                },
                'user_id' => function () {
                    return User::inRandomOrder()->first()->id;
                },
            ]
        );
    }
}
