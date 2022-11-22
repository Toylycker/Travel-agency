<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notes = ['Invitation', 'Registration', 'Accommodation', 
        'Camping tents with sleeping bags', 'Guide', 'Comfortable transport',
        'Meal (FB) during the all route', 'Entrance fee', 'All transfer', 'Daily 1.5lt water',
        'Fee for using cameras in monuments', 'Insurance', 'Visa fee', 'Migration tax' ];
    }
}
