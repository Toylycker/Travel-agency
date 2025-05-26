<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            LocationSeeder::class,
            // UserSeeder::class,
            CategorySeeder::class,
            SubjectSeeder::class,
            CurrencySeeder::class,
            ProcessSeeder::class,
            NoteSeeder::class,
            CostDaySeeder::class,
        ]);
        \App\Models\Hotel::factory(10)->create();
        \App\Models\Post::factory(20)->create();
        \App\Models\Place::factory(50)->create();
        \App\Models\Tour::factory(10)->create();
        \App\Models\Application::factory(10)->create();
        // \App\Models\Room::factory(20)->create();
        // \App\Models\Meal::factory(20)->create();
        // \App\Models\Guide::factory(10)->create();
        // \App\Models\Transportation::factory(10)->create();
        // \App\Models\CustomCost::factory(5)->create();
        \App\Models\Cost::factory(50)->create();

    }
}
