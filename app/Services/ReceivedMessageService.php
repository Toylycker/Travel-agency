<?php

namespace App\Services;

use App\Models\ReceivedMessage;

class ReceivedMessageService extends BaseService
{
    public function __construct(ReceivedMessage $receivedMessage)
    {
        parent::__construct($receivedMessage);
    }
} 