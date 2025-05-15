<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends BaseModel
{
    use HasFactory;
    protected $guarded = ['id'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function customTour()
    {
        return $this->belongsToMany(CustomTour::class, 'custom_tour_places');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_places');
    }

    public function days()
    {
        return $this->belongsToMany(Day::class, 'day_places');
    }

    public function costs()
    {
        return $this->morphMany(Cost::class, 'costable');
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
