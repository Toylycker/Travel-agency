<?php

namespace App\Services;

use App\Models\Application;

class ApplicationService extends BaseService
{
    public function __construct(Application $application)
    {
        parent::__construct($application);
    }
} 