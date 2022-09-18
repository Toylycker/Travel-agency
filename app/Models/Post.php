<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'subject_posts');
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

    public function texts()
    {
        return $this->morphMany(Text::class, 'textable');
    }
}
