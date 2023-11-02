<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class HallTemplate extends Model
{
    use HasFactory, HasUuids;

    protected $casts = [
        'is_available' => 'boolean',
        'number' => 'integer',
    ];

    protected $fillable = [
        'number',
        'address',
        'is_available',
    ];

    public function seats(): MorphMany
    {
        return $this->morphMany(Seat::class, 'seatable');
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('is_available', true);
    }

    public function scopeSearched(Builder $query, string $s): Builder
    {
        return $query->where('address', 'like', "%{$s}%");
    }
}
