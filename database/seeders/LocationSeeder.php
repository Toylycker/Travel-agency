<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = ['Ashgbat', 'Akhal', 'Mary', 'Balkan', 'Lebap', 'Dashoguz', 'Awaza'];

        foreach ($locations as $location) {
            Location::create([
                'name' => $location[0],
            ]);
        }
    }
}
