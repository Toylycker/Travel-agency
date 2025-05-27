<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    public function scopeCostsWithoutDays($query)
    {
        return $query->with([
            'costs' => fn($q) => $q->without(['days'])
        ]);
    }
} 