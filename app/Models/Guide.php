<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Guide extends BaseModel
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function days(): BelongsToMany
    {
        return $this->belongsToMany(Day::class, 'day_guide');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function videos()
    {
        return $this->morphMany(Video::class, 'videoable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
} 