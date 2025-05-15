<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Meal extends BaseModel
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function days(): BelongsToMany
    {
        return $this->belongsToMany(Day::class, 'day_meal')
            ->withPivot(['serving_time', 'serving_location', 'special_requests'])
            ->withTimestamps();
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