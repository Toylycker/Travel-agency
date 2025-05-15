<?php

namespace App\Services;

use App\Models\Hotel;

class HotelService extends BaseService
{
    public function __construct(Hotel $hotel)
    {
        parent::__construct($hotel);
    }
} 