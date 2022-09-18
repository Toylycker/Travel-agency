<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    public function links()
    {
        return $this->morphMany(Link::class, 'linkable');
    }

    public function children()
    {
        return $this->hasMany(Location::class)->with('locations');
    }

    public function places()
    {
        return $this->hasMany(Place::class);
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }


}
