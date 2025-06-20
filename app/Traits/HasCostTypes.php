<?php

namespace App\Traits;

use App\Models\CustomCost;
use App\Models\Transportation;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Guide;
use App\Models\Meal;
use App\Models\Place;

trait HasCostTypes
{

    public static function getCostableTypes(): array
    {
        return [
            'App\\Models\\Transportation' => 'Transportation',
            'App\\Models\\Hotel' => 'Hotel',
            'App\\Models\\Room' => 'Room',
            'App\\Models\\Guide' => 'Guide',
            'App\\Models\\Meal' => 'Meal',
            'App\\Models\\CustomCost' => 'CustomCost',
            'App\\Models\\Place' => 'Place',
        ];
    }

    public static function getCostableItems(): array
    {
        return [
            'App\\Models\\Transportation' => Transportation::where('is_active', true)->get(['id', 'license_plate as name']),
            'App\\Models\\Hotel' => Hotel::get(['id', 'name']),
            'App\\Models\\Room' => Room::get(['id', 'name']),
            'App\\Models\\Guide' => Guide::where('is_active', true)->get(['id', 'name']),
            'App\\Models\\Meal' => Meal::where('is_active', true)->get(['id', 'name']),
            'App\\Models\\CustomCost' => CustomCost::get(['id', 'name']),
            'App\\Models\\Place' => Place::get(['id', 'name']),
        ];
    }
} 