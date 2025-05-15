<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cost>
 */
class CostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'cost' => fake()->randomFloat(2, 10, 1000),
            'number_of_people' => fake()->numberBetween(1, 50),
            'description' => fake()->optional()->paragraph(),
            'is_active' => fake()->boolean(90),
        ];
    }

    /**
     * Configure the factory for per person costs.
     */
    public function perPerson(): static
    {
        return $this->state(fn (array $attributes) => [
            'number_of_people' => 1,
        ]);
    }

    /**
     * Configure the factory for group costs.
     */
    public function forGroup(int $size = null): static
    {
        return $this->state(fn (array $attributes) => [
            'number_of_people' => $size ?? fake()->numberBetween(10, 50),
        ]);
    }
} 