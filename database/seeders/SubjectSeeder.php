<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = [
            'advantures', 'essiantial mustknows',
             'ancient', 'entertaiment', 'people', 'customs'
        ];
        foreach ($subjects as $subject) {
            Subject::create(['name'=> $subject]);
        }
    }
}
