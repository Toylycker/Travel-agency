<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends BaseModel
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;


    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function customTours(): HasMany
    {
        return $this->hasMany(CustomTour::class);
    }

    public function partners(): HasMany
    {
        return $this->hasMany(Partner::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }


}
