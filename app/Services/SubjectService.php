<?php

namespace App\Services;

use App\Models\Subject;

class SubjectService extends BaseService
{
    public function __construct(Subject $subject)
    {
        parent::__construct($subject);
    }
} 