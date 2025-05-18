<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Meal extends BaseModel
{
    use HasFactory;
    
    protected $guarded = ['id'];
    public $timestamps = false;

    protected $casts = [
        'allergens' => 'array',
    ];

    public function days(): BelongsToMany
    {
        return $this->belongsToMany(Day::class, 'day_meal')
            ->withPivot(['serving_time', 'serving_location', 'special_requests'])
            ->withTimestamps();
    }

    public function costs()
    {
        return $this->morphMany(Cost::class, 'costable');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function videos()
    {
        return $this->morphMany(Video::class, 'videoable');
    }
} 