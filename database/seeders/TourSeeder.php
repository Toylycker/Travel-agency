<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TourSeeder extends Seeder
{
    public function run()
    {
        $tours = [
            [
                'name' => 'Ashgabat to Kunya -Urgench and the Garagums lights ',
                'main_image' => 'tour1mainImage',
                'body' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde, numquam quidem molestias molestiae, nulla rem provident animi aspernatur eveniet id excepturi necessitatibus, veniam odio voluptate consequatur soluta velit ut ab?',
                'total_days'=>3,
                'prices'=>'381$-466$'
            ]
        ];
    }
}
