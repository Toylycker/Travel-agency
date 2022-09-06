<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;


    /**
     * Get all of the places for the Tour
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function days()
    {
        return $this->hasMany(Day::class);
    }

    // public function places()
    // {
    //     return $this->hasManyThrough(
    //         Place::class,
    //         Day::class,
    //         'tour_id', // Foreign key on users table...
    //         'dayPLaces', // Foreign key on posts table...
    //         'id', // Local key on countries table...
    //         'id' // Local key on users table...
    //     );
    // }



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
