<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends BaseModel
{
    use HasFactory;
    protected $guarded = ['id'];

    public function linkable()
    {
        return $this->morphTo();
    }
}
