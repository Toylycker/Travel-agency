<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transportation extends BaseModel
{
    use HasFactory;

    protected $table = 'transportations';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function days(): BelongsToMany
    {
        return $this->belongsToMany(Day::class, 'day_transportation')
            ->withPivot(['pickup_time', 'dropoff_time', 'pickup_location', 'dropoff_location', 'estimated_duration', 'route_notes'])
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