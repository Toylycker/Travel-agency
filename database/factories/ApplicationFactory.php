<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Country;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class ApplicationFactory extends Factory
{

    // public function configure()
    // {
    //     return $this->afterMaking(function (Application $application) {
    //         //
    //     })->afterCreating(function (Application $application) {
    //         $makeRelative = rand(1, 3); // also the id of the process of application
    //         $processes = array();
    //         for ($i=1; $i <= $makeRelative; $i++) { 
    //             array_push($processes, $i);
    //         }
    //         $application->processes()->syncWithPivotValues($processes,['status' => 'success approved']);

    //         if ($makeRelative ===3) {
    //             $numberOfRelatives = rand(1, 3);
    //             $processes = array();
    //             for ($i=1; $i <= $numberOfRelatives; $i++) { 
    //                 array_push($processes, $i);
    //             }
    //             for ($i=0; $i < $numberOfRelatives; $i++) { 
    //                 Application::create([
    //                     'name'=> $this->faker->name,
    //                     'surname' => $this->faker->lastName,
    //                     'country_id'=> Country::inRandomOrder()->first()->id, // it is because relative can be from another country.
    //                     'user_id'=> null,
    //                     'application_id'=> $application->id,
    //                     'isRelative' => 1,
    //                 ])->processes()->syncWithPivotValues($processes, ['status' => 'success approved']);
    //             }
    //         }
    //     });
    // }

    public function definition()
    {
        // $user = User::inRandomOrder()->with('country')->first();
        return [
            'name'=> $this->faker->name,
            'surname' => $this->faker->lastName,
            'country_id'=> Country::inRandomOrder()->first()->id,
            'email'=>$this->faker->unique()->safeEmail(),
            'phone'=>rand(111111111, 99999999999999),
            'quantity'=>rand(1, 4),
            'arrival'=>now(),
            'departure'=>now(),
            'tour_id'=>Tour::inRandomOrder()->first()->id,
            // 'user_id'=> $user->id,
            // 'application_id'=> null,
            // 'isRelative' => null,
        ];
    }
}
