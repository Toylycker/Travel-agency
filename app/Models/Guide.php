<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Guide extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    protected $casts = [
            'languages' => 'array',
        ];

    public function days(): BelongsToMany
    {
        return $this->belongsToMany(Day::class, 'day_guide')
            ->withPivot(['start_time', 'end_time', 'notes'])
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

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
} 