<?php

namespace App\Services;

use App\Models\Price;

class PriceService extends BaseService
{
    public function __construct(Price $price)
    {
        parent::__construct($price);
    }
} 