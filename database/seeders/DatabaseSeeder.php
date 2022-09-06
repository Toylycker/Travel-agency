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
    public function run()
    {
        $this->call([
            CountrySeeder::class,
            CategorySeeder::class,
            SubjectSeeder::class,
            CurrencySeeder::class,
            ProcessSeeder::class,
        ]);
        \App\Models\User::factory(10)->create();
        \App\Models\Location::factory(10)->create();
        \App\Models\Place::factory(50)->create();
        \App\Models\Post::factory(20)->create();
        \App\Models\Tour::factory(10)->create();
        \App\Models\Application::factory(10)->create();

    }
}
