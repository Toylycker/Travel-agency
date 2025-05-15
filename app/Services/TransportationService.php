<?php

namespace App\Services;

use App\Models\Transportation;

class TransportationService extends BaseService
{
    public function __construct(Transportation $transportation)
    {
        parent::__construct($transportation);
    }
} 