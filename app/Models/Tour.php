<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function notes(): BelongsToMany
    {
        return $this->belongsToMany(Note::class, 'note_tours')->withPivot(['status']) ;
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

    public function prices()
    {
        return $this->morphMany(Price::class, 'priceable');
    }

    public function included() {
        return $this->notes()->wherePivot('status', 'included');
    }

    public function non_included() {
        return $this->notes()->wherePivot('status', 'non included');
    }
}
