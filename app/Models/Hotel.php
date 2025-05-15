<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends BaseModel
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;


    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function days(): BelongsToMany
    {
        return $this->belongsToMany(Day::class, 'day_hotels');
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

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
