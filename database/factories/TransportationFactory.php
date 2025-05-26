<?php

namespace Database\Factories;

use App\Models\Transportation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transportation>
 */
class TransportationFactory extends Factory
{
    protected $model = Transportation::class;
    protected $vehicleTypes = [
        'car' => [
            'brands' => ['Toyota', 'Mercedes', 'BMW', 'Audi', 'Lexus'],
            'seats' => [4, 5],
        ],
        'van' => [
            'brands' => ['Mercedes Sprinter', 'Volkswagen Crafter', 'Ford Transit', 'Toyota HiAce'],
            'seats' => [8, 9, 12, 15],
        ],
        'bus' => [
            'brands' => ['Mercedes Tourismo', 'Setra', 'MAN', 'Volvo'],
            'seats' => [30, 35, 40, 45, 50],
        ],
    ];

    public function definition(): array
    {
        $type = fake()->randomElement(array_keys($this->vehicleTypes));
        $brand = fake()->randomElement($this->vehicleTypes[$type]['brands']);
        
        return [
            'type' => $type,
            'brand' => $brand,
            'model' => fake()->word(),
            'year' => fake()->year('-10 years'),
            'seats' => fake()->randomElement($this->vehicleTypes[$type]['seats']),
            'license_plate' => strtoupper(fake()->bothify('??####??')),
            'color' => fake()->safeColorName(),
            'has_wifi' => fake()->boolean(70),
            'has_ac' => fake()->boolean(90),
            'has_tv' => $type !== 'car' ? fake()->boolean(60) : false,
            'features' => fake()->randomElements([
                'USB Charging',
                'Bluetooth Audio',
                'Leather Seats',
                'Panoramic Roof',
                'Luggage Space',
                'Mini Fridge',
                'Reading Lights',
                'Reclining Seats'
            ], fake()->numberBetween(2, 5)),
            'insurance_expiry' => fake()->dateTimeBetween('now', '+2 years')->format('Y-m-d'),
            'technical_inspection_expiry' => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'is_active' => fake()->boolean(90),
        ];
    }

    /**
     * Configure the factory for luxury vehicles.
     */
    public function luxury(): static
    {
        return $this->state(function (array $attributes) {
            $type = $attributes['type'] ?? 'car';
            return [
                'has_wifi' => true,
                'has_ac' => true,
                'has_tv' => $type !== 'car',
                'features' => array_merge($attributes['features'] ?? [], [
                    'Premium Sound System',
                    'Leather Seats',
                    'Climate Control',
                    'Privacy Glass'
                ]),
            ];
        });
    }

    /**
     * Configure the factory for a specific vehicle type.
     */
    public function ofType(string $type): static
    {
        return $this->state(function (array $attributes) use ($type) {
            if (!isset($this->vehicleTypes[$type])) {
                throw new \InvalidArgumentException("Invalid vehicle type: {$type}");
            }

            $brand = fake()->randomElement($this->vehicleTypes[$type]['brands']);
            return [
                'type' => $type,
                'brand' => $brand,
                'seats' => fake()->randomElement($this->vehicleTypes[$type]['seats']),
                'has_tv' => $type !== 'car' ? fake()->boolean(60) : false,
            ];
        });
    }
} 