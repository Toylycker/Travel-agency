<?php

namespace App\Services;

use App\Models\Currency;

class CurrencyService extends BaseService
{
    public function __construct(Currency $currency)
    {
        parent::__construct($currency);
    }
} 