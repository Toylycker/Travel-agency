<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Day extends BaseModel
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;


    /**
     * Get the tour that owns the Day
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function places(): BelongsToMany
    {
        return $this->belongsToMany(Place::class, 'day_places');
    }

    public function hotels(): BelongsToMany
    {
        return $this->belongsToMany(Hotel::class, 'day_hotels');
    }

    public function transportations(): BelongsToMany
    {
        return $this->belongsToMany(Transportation::class, 'day_transportation')
            ->withPivot(['pickup_time', 'dropoff_time', 'pickup_location', 'dropoff_location', 'estimated_duration', 'route_notes'])
            ->withTimestamps();
    }

    public function meals(): BelongsToMany
    {
        return $this->belongsToMany(Meal::class, 'day_meal')
            ->withPivot(['serving_time', 'serving_location', 'special_requests'])
            ->withTimestamps();
    }

    public function guides(): BelongsToMany
    {
        return $this->belongsToMany(Guide::class, 'day_guide')
            ->withPivot(['start_time', 'end_time', 'notes'])
            ->withTimestamps();
    }

    public function costs(): BelongsToMany
    {
        return $this->belongsToMany(Cost::class, 'cost_day')
            ->withPivot(['notes'])
            ->withTimestamps();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function videos()
    {
        return $this->morphMany(Video::class, 'videoable');
    }

    public function links()
    {
        return $this->morphMany(Link::class, 'linkable');
    }
}
