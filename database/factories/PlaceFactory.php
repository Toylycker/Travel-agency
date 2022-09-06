<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PLace;
use App\Models\Location;


class PlaceFactory extends Factory
{
    public function configure()
    {
        return $this->afterMaking(function (Place $place) {
            //
        })->afterCreating(function (Place $place) {
            $rand  = rand(1, 3);
            $place->categories()->sync(Category::inRandomOrder()->take($rand)->pluck('id'));
        });
    }

    public function definition()
    {
        
        return [
            'location_id' => Location::inRandomOrder()->first()->id,
            'name' => $this->faker->word(),
            'body' => $this->faker->paragraph(6),
        ];
    }
}
