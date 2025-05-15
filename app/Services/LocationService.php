<?php

namespace App\Services;

use App\Models\Location;

class LocationService extends BaseService
{
    public function __construct(Location $location)
    {
        parent::__construct($location);
    }
} 