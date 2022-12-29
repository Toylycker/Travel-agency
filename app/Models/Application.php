<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $hidden = ['pivot'];
    protected $fillable = [
        'name',
        'surname',
        'country_id',
        'email',
        'phone',
        'tour_id',
        'quantity',
        'arrival',
        'departure',
    ];
    protected $casts = [
        'arrival' => 'datetime:Y-m-d',
        'departure' => 'datetime:Y-m-d',
    ];

    public function processes()
    {
        return $this->belongsToMany(Process::class, 'application_processes')
            ->withTimeStamps()
            ->withPivot(['status', 'comment']);
    }

    public function childrens()
    {
        return $this->hasMany(Application::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the country that owns the Application
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    // public function places()
    // {
    //     return $this->hasMany(Place::class);
    // }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
