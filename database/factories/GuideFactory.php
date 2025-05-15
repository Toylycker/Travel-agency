<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guide>
 */
class GuideFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'resume_path' => fake()->optional()->filePath(),
            'bio' => fake()->paragraphs(2, true),
            'years_of_experience' => fake()->numberBetween(1, 30),
            'languages' => fake()->randomElements(['English', 'Russian', 'Turkish', 'Spanish', 'French', 'German', 'Chinese'], fake()->numberBetween(1, 4)),
            'license_number' => fake()->optional()->regexify('[A-Z]{2}[0-9]{6}'),
            'license_expiry' => fake()->optional()->dateTimeBetween('now', '+5 years'),
            'is_active' => fake()->boolean(80), // 80% chance of being active
        ];
    }

    /**
     * Indicate that the guide is experienced.
     */
    public function experienced(): static
    {
        return $this->state(fn (array $attributes) => [
            'years_of_experience' => fake()->numberBetween(10, 30),
            'languages' => fake()->randomElements(['English', 'Russian', 'Turkish', 'Spanish', 'French', 'German', 'Chinese'], fake()->numberBetween(3, 5)),
        ]);
    }

    /**
     * Indicate that the guide is a novice.
     */
    public function novice(): static
    {
        return $this->state(fn (array $attributes) => [
            'years_of_experience' => fake()->numberBetween(1, 3),
            'languages' => fake()->randomElements(['English', 'Russian', 'Turkish'], 1),
        ]);
    }
} 