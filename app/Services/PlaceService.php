<?php

namespace App\Services;

use App\Models\Place;

class PlaceService extends BaseService
{
    public function __construct(Place $place)
    {
        parent::__construct($place);
    }
} 