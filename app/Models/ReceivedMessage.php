<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivedMessage extends BaseModel
{
    use HasFactory;
    protected $guarded = ['id'];
}
