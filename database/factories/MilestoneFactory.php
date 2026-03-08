<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Milestone>
 */
class MilestoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'due_date' => $this->faker->optional()->dateTimeBetween(startDate: now(), endDate: now()->addYear())?->format('Y-m-d'),
            'is_completed' => $this->faker->boolean(),
            'feature_id' => null,
        ];
    }
}
