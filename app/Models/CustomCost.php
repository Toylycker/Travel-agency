<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get all of the owning costable models.
     */
    public function costs()
    {
        return $this->morphMany(Cost::class, 'costable');
    }
} 