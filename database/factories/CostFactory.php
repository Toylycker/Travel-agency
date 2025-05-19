<?php

namespace Database\Factories;

use App\Models\Cost;
use App\Models\Transportation;
use App\Models\Room;
use App\Models\Guide;
use App\Models\Meal;
use App\Models\Day;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cost>
 */
class CostFactory extends Factory
{
    protected $model = Cost::class;

    public function definition(): array
    {
        $costableTypes = [
            Transportation::class,
            // Room::class,
            Guide::class,
            Meal::class
        ];

        $costableType = $this->faker->randomElement($costableTypes);
        $costable = $costableType::factory()->create();

        return [
            'name' => $this->faker->words(3, true),
            'cost' => $this->faker->randomFloat(2, 10, 1000),
            'number_of_people' => $this->faker->numberBetween(1, 10),
            'costable_type' => $costableType,
            'costable_id' => $costable->id,
            'description' => $this->faker->optional()->sentence(),
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure()
    {
        return $this->afterCreating(function (Cost $cost) {
            // Get first 2 days and attach this cost to them
            $days = Day::inRandomOrder()->take(2)->get();
            foreach ($days as $day) {
                $day->costs()->attach($cost->id, [
                    'notes' => $this->faker->optional()->sentence()
                ]);
            }
        });
    }

    /**
     * Indicate that the cost is not linked to any item.
     */
    public function unlinked(): static
    {
        return $this->state(fn (array $attributes) => [
            'costable_type' => null,
            'costable_id' => null,
        ]);
    }

    /**
     * Indicate that the cost is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
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
            'number_of_people' => $size ?? $this->faker->numberBetween(2, 50),
        ]);
    }
} 