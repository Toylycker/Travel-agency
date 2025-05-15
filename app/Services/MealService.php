<?php

namespace App\Services;

use App\Models\Meal;

class MealService extends BaseService
{
    public function __construct(Meal $meal)
    {
        parent::__construct($meal);
    }
} 