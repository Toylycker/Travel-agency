<?php

namespace App\Services;

use App\Models\CustomTour;

class CustomTourService extends BaseService
{
    public function __construct(CustomTour $customTour)
    {
        parent::__construct($customTour);
    }
} 