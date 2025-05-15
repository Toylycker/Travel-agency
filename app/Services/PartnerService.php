<?php

namespace App\Services;

use App\Models\Partner;

class PartnerService extends BaseService
{
    public function __construct(Partner $partner)
    {
        parent::__construct($partner);
    }
} 