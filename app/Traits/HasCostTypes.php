<?php

namespace App\Traits;

trait HasCostTypes
{
    public static function getCostTypes(): array
    {
        return [
            'transportation' => 'Transportation',
            'Hotel' => 'Hotel',
            'Room' => 'Room',
            'Guide' => 'Guide',
            'Meal' => 'Meal'
        ];
    }

    public static function getCostableTypes(): array
    {
        return [
            'App\\Models\\Transportation' => 'Transportation',
            'App\\Models\\Hotel' => 'Hotel',
            'App\\Models\\Room' => 'Room',
            'App\\Models\\Guide' => 'Guide',
            'App\\Models\\Meal' => 'Meal'
        ];
    }
} 