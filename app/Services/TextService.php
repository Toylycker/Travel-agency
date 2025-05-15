<?php

namespace App\Services;

use App\Models\Text;

class TextService extends BaseService
{
    public function __construct(Text $text)
    {
        parent::__construct($text);
    }
} 