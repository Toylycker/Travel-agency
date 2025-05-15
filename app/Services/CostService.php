<?php

namespace App\Services;

use App\Models\Cost;

class CostService extends BaseService
{
    public function __construct(Cost $cost)
    {
        parent::__construct($cost);
    }
} 