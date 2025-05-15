<?php

namespace App\Services;

use App\Models\Room;

class RoomService extends BaseService
{
    public function __construct(Room $room)
    {
        parent::__construct($room);
    }
} 