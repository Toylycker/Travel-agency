<?php

namespace App\Models;

use App\Traits\HasCostTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cost extends BaseModel
{
    use HasFactory, HasCostTypes;
    
    protected $guarded = ['id'];

    protected $with = ['days.tour'];

    protected $casts = [
        'cost' => 'decimal:2',
        'number_of_people' => 'integer',
        'is_active' => 'boolean',
    ];

    public function costable()
    {
        return $this->morphTo();
    }

    public function days()
    {
        return $this->belongsToMany(Day::class, 'cost_day')
             ->withPivot(['notes', 'quantity'])
            ->withTimestamps();
    }
} 