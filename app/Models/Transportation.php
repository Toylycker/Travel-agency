<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transportation extends BaseModel
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function days(): BelongsToMany
    {
        return $this->belongsToMany(Day::class, 'day_transportation');
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