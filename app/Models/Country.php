<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    /**
     * Get all of the users for the Country
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all of the partners for the Country
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function partners(): HasMany
    {
        return $this->hasMany(Partner::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }


}
