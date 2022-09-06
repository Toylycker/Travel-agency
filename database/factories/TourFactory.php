<?php

namespace Database\Factories;

use App\Models\Day;
use App\Models\Tour;
use App\Models\PLace;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourFactory extends Factory
{
    public function configure()
    {
        return $this->afterMaking(function (Tour $tour) {
            //
        })->afterCreating(function (Tour $tour) {
            $days = rand(3, 9);
            for ($i=1; $i < $days; $i++) { 
                # code...
                $day = new Day();
                $day->day_number = $i;
                $day->title = $this->faker->sentence(1);
                $day->body = $this->faker->paragraph(6);
                $day->tour_id = $tour->id;
                $day->save();
                $rand = rand(1, 3);
                $day->places()->sync(Place::inRandomOrder()->take($rand)->pluck('id'));
            }
            
        });
    }

    public function definition()
    {
        $rand = rand(3, 6);
        return [
            'name'=>$this->faker->sentence(1),
            'body' => $this->faker->paragraph(6),
            'total_days' => $rand,
            'total_nights' => $rand+1,
            'price' => rand(1000, 2000)
        ];
    }
}
