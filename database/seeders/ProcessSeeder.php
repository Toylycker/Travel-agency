<?php

namespace Database\Seeders;

use App\Models\Process;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $processes = [
            ['applied', 1], 
            ['approved', 2], 
            ['pending', 3], 
            ['paid', 4, ],
            ['applied to embassy', 5], 
            ['visa is ready', 6]
        ];

        foreach ($processes as $process) {
            Process::create([
                'name' => $process[0],
                'sort_order'=>$process[1]
            ]);
        }
    }
}
