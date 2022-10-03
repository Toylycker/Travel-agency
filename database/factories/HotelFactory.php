<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'location_id'=>Location::inRandomOrder()->first()->id,
            'name' => $this->faker->word(),
            'stars'=>rand(1,5),
            'body'=> $this->faker->sentence(6)

        ];
    }
}
