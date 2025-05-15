<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Process extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;


    /**
     * The applications that belong to the Process
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class, 'application_processes');
    }
}
