<?php

namespace App\Services;

use App\Models\Process;

class ProcessService extends BaseService
{
    public function __construct(Process $process)
    {
        parent::__construct($process);
    }
} 