<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Movie extends Model
{
    use HasFactory, HasUuids, Sluggable;

    const AGE_RESTRICTIONS = ['0+', '6+', '12+', '16+', '18+'];

    protected $casts = [
        'release_year' => 'integer',
        'start_showing' => 'date',
        'end_showing' => 'date',
    ];

    protected $fillable = [
        'title',
        'slug',
        'description',
        'priority',
        'duration_in_minutes',
        'age_restriction',
        'thumbnail',
        'release_year',
        'original_title',
        'director',
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
            ],
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

    public function banner(): HasOne
    {
        return $this->hasOne(MovieBanner::class, 'movie_id', 'id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function thumbnailPath(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => '/storage/'.$attributes['thumbnail'],
        );
    }

    public function formattedDuration(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                $hours = floor($attributes['duration_in_minutes'] / 60);
                $minutes = $attributes['duration_in_minutes'] % 60;

                return sprintf('%d год %02d хв', $hours, $minutes);
            },
        );
    }

    public function scopeMissingCompleted(Builder $query): Builder
    {
        return $query->where('end_showing', '>=', now());
    }

    public function scopeCurrentlyScreeningWithGenres(Builder $query): Builder
    {
        return $query->where('end_showing', '>=', now())->where('start_showing', '<=', now())
            ->with('genres');
    }

    public function scopeScreeningSoonWithGenres(Builder $query): Builder
    {
        return $query->where('start_showing', '>=', now())
            ->with('genres');
    }

    public function scopeHasBanner(Builder $query): Builder
    {
        return $query->whereHas('banner')->where('end_showing', '>=', now());
    }

    public function scopeMissingBanner(Builder $query): Builder
    {
        return $query->whereDoesntHave('banner');
    }

    public function scopeFiltered(Builder $query, string $s): Builder
    {
        return $query->where('title', 'like', "%{$s}%");
    }
}
