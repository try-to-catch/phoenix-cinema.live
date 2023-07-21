<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    use HasFactory, HasUuids, Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'duration_in_minutes',
        'age_restriction',
        'thumbnail',
        'release_date',
        'original_title',
        'production_country',
        'studio',
        'main_cast',
        'start_showing',
        'end_showing',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ]
        ];
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class);
    }
}
