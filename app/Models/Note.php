<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Note extends BaseModel
{
    use HasFactory;
    public $timestamps = false;
    // protected $hidden = ['pivot'];
    protected $guarded = [''];

    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'note_tours')->withPivot(['status']) ;
    }
}
