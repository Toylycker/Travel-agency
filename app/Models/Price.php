<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends BaseModel
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    public function priceable()
    {
        return $this->morphTo();
    }
}
