<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Seat extends Model
{
    use HasFactory, HasUuids;

    const SEAT_TYPES = [
        'standard',
        'premium',
        'blank',
    ];

    protected $casts = [
        'is_taken' => 'boolean',
    ];

    protected $fillable = [
        'seat_number',
        'row_number',
        'type',
        'is_taken',
    ];

    public function scopeOrderByPosition(Builder $query): Builder
    {
        return $query->orderBy('row_number')->orderBy('seat_number');
    }

    public function seatable(): MorphTo
    {
        return $this->morphTo();
    }
}
