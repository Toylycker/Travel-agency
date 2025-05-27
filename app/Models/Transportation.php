<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transportation extends BaseModel
{
    use HasFactory;

    protected $table = 'transportations';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected $appends = ['name'];

    protected $casts = [
        'has_wifi' => 'boolean',
        'has_ac' => 'boolean',
        'has_tv' => 'boolean',
        'is_active' => 'boolean',
        'features' => 'array',
        'insurance_expiry' => 'date',
        'technical_inspection_expiry' => 'date'
    ];

    public function costs()
    {
        return $this->morphMany(Cost::class, 'costable');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function videos()
    {
        return $this->morphMany(Video::class, 'videoable');
    }

    public function getNameAttribute(): ?string
    {
        return $this->model;
    }

    protected function setInsuranceExpiryAttribute($value)
    {
        if (!$value) {
            $this->attributes['insurance_expiry'] = null;
            return;
        }
    
        if (strpos($value, '/') !== false) {
            $parts = explode('/', $value);
            if (count($parts) === 3) {
                $this->attributes['insurance_expiry'] = "{$parts[2]}-{$parts[1]}-{$parts[0]}";
                return;
            }
        }
    
        $this->attributes['insurance_expiry'] = substr($value, 0, 10);
    }

    protected function setTechnicalInspectionExpiryAttribute($value)
    {
        if (!$value) {
            $this->attributes['technical_inspection_expiry'] = null;
            return;
        }
        
        if (strpos($value, '/') !== false) {
            $parts = explode('/', $value);
            if (count($parts) === 3) {
                $this->attributes['technical_inspection_expiry'] = "{$parts[2]}-{$parts[1]}-{$parts[0]}";
                return;
            }
        }
        
        $this->attributes['technical_inspection_expiry'] = substr($value, 0, 10);
    }
} 