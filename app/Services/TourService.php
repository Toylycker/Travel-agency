<?php

namespace App\Services;

use App\Models\Tour;

class TourService extends BaseService
{
    public function __construct(Tour $tour)
    {
        parent::__construct($tour);
    }
} 