<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomTour extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'email',
        'note',
        'ip'
    ];


    public function places()
    {
        return $this->belongsToMany(Place::class, 'custom_tour_places');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
