<?php

namespace App\Models;

class Cost extends BaseModel
{
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