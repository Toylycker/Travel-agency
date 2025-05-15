<?php

namespace App\Services;

use App\Models\Guide;

class GuideService extends BaseService
{
    public function __construct(Guide $guide)
    {
        parent::__construct($guide);
    }
} 