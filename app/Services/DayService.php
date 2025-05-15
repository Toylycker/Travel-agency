<?php

namespace App\Services;

use App\Models\Day;

class DayService extends BaseService
{
    public function __construct(Day $day)
    {
        parent::__construct($day);
    }
} 