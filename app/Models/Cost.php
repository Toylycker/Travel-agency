<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cost extends BaseModel
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'cost' => 'decimal:2',
        'number_of_people' => 'integer',
    ];

    public function costable()
    {
        return $this->morphTo();
    }

    public function days()
    {
        return $this->belongsToMany(Day::class, 'cost_day')
            ->withPivot(['notes'])
            ->withTimestamps();
    }
} 