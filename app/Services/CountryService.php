<?php

namespace App\Services;

use App\Models\Country;

class CountryService extends BaseService
{
    public function __construct(Country $country)
    {
        parent::__construct($country);
    }
} 