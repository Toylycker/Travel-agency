<?php

namespace Database\Factories;

use App\Models\Day;
use App\Models\Hotel;
use App\Models\Image;
use App\Models\Note;
use App\Models\Tour;
use App\Models\PLace;
use App\Models\Price;
use App\Models\Text;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourFactory extends Factory
{
    public function configure()
    {
        return $this->afterMaking(function (Tour $tour) {
            //
        })->afterCreating(function (Tour $tour) {
            $notes = Note::inRandomOrder()->take(rand(4,7))->get();
            foreach ($notes as $note) {
                $tour->notes()->attach($note->id, ['status'=>rand(0,1)?'included':'non included']);
            }

            $randForPrice = rand(3, 5);
            for ($i=0; $i <= $randForPrice; $i++) { 
                Price::create([
                 'name'=>$this->faker->word(),
                 'price'=>rand(100,200), 
                 'priceable_id'=>$tour->id,
                'priceable_type'=>'App\Models\Tour']);
            }


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
                $day->places()->attach(Place::inRandomOrder()->take($rand)->pluck('id'));
                $day->hotels()->attach(Hotel::inRandomOrder()->first()->id);
                $randForTexts = rand(3, 6);
                for ($b=0; $b <= $randForTexts; $b++) { 
                    Text::create(['text_number'=>$b+1, 'title'=>'text' . $b+1, 'body'=>$this->faker->paragraph(9), 'textable_id'=>$day->id, 'textable_type'=>'App\Models\Place']);
                }
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
            'tour_prices' => rand(1000, 2000).'-'.rand(1000, 2000),
            'main_image'=>''
        ];
    }
}
