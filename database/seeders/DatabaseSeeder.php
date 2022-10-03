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
        \App\Models\Note::factory(15)->create();
        echo('notes done');
        \App\Models\User::factory(10)->create();
        echo('done user');
        \App\Models\Location::factory(10)->create();
        echo('done Location');
        \App\Models\Hotel::factory(10)->create();
        echo('done Hotel');
        \App\Models\Place::factory(50)->create();
        echo('done Place');
        \App\Models\Post::factory(20)->create();
        echo('done Post');
        \App\Models\Tour::factory(10)->create();
        echo('done Tour');
        \App\Models\Application::factory(10)->create();
        echo('done Application');
        \App\Models\Room::factory(20)->create();

    }
}
