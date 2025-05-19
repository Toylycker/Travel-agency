<?php

namespace Database\Seeders;

use App\Models\Cost;
use App\Models\Day;
use Illuminate\Database\Seeder;

class CostDaySeeder extends Seeder
{
    public function run(): void
    {
        // Get all days
        $days = Day::all();

        // For each day, attach 1-2 random costs
        foreach ($days as $day) {
            $numberOfCosts = rand(1, 2);
            $costs = Cost::factory()->count($numberOfCosts)->create();
            
            foreach ($costs as $cost) {
                $day->costs()->attach($cost->id, [
                    'notes' => fake()->optional()->sentence()
                ]);
            }
        }
    }
} 