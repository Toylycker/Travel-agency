<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meal>
 */
class MealFactory extends Factory
{
    protected $mealTypes = [
        'breakfast' => [
            'Continental Breakfast',
            'American Breakfast',
            'English Breakfast',
            'Healthy Breakfast Bowl',
            'Breakfast Buffet'
        ],
        'lunch' => [
            'Business Lunch',
            'Light Lunch Set',
            'Traditional Lunch',
            'Gourmet Lunch',
            'Lunch Buffet'
        ],
        'dinner' => [
            'Fine Dining Experience',
            'Traditional Dinner',
            'Themed Dinner',
            'Gala Dinner',
            'BBQ Dinner'
        ],
        'snack' => [
            'Afternoon Tea',
            'Light Snacks',
            'Fruit Platter',
            'Pastry Selection',
            'Local Delicacies'
        ]
    ];

    protected $cuisines = [
        'Turkish',
        'International',
        'Mediterranean',
        'Asian',
        'European',
        'Middle Eastern',
        'Local'
    ];

    public function definition(): array
    {
        $type = fake()->randomElement(array_keys($this->mealTypes));
        $name = fake()->randomElement($this->mealTypes[$type]);
        
        return [
            'name' => $name,
            'description' => fake()->paragraph(),
            'type' => $type,
            'cuisine' => fake()->randomElement($this->cuisines),
            'is_vegetarian' => fake()->boolean(30),
            'is_vegan' => fake()->boolean(20),
            'is_halal' => fake()->boolean(80),
            'contains_nuts' => fake()->boolean(40),
            'contains_dairy' => fake()->boolean(60),
            'contains_gluten' => fake()->boolean(70),
            'allergens' => fake()->randomElements([
                'Eggs',
                'Fish',
                'Shellfish',
                'Tree Nuts',
                'Peanuts',
                'Wheat',
                'Soy',
                'Milk'
            ], fake()->numberBetween(0, 4)),
            'calories' => fake()->numberBetween(200, 1200),
            'price' => fake()->randomFloat(2, 10, 100),
            'preparation_time' => fake()->numberBetween(15, 120),
            'is_active' => fake()->boolean(90),
        ];
    }

    /**
     * Configure the factory for vegetarian meals.
     */
    public function vegetarian(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_vegetarian' => true,
            'is_halal' => true,
        ]);
    }

    /**
     * Configure the factory for vegan meals.
     */
    public function vegan(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_vegetarian' => true,
            'is_vegan' => true,
            'is_halal' => true,
            'contains_dairy' => false,
        ]);
    }

    /**
     * Configure the factory for a specific meal type.
     */
    public function ofType(string $type): static
    {
        if (!isset($this->mealTypes[$type])) {
            throw new \InvalidArgumentException("Invalid meal type: {$type}");
        }

        return $this->state(function (array $attributes) use ($type) {
            return [
                'type' => $type,
                'name' => fake()->randomElement($this->mealTypes[$type]),
            ];
        });
    }
} 