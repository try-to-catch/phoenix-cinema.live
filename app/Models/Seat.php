<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Seat extends Model
{
    use HasFactory, HasUuids;

    const SEAT_TYPES = [
        1 => 'blank',
        2 => 'standard',
        3 => 'premium',
    ];

    public $timestamps = false;
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

    public function type(): Attribute
    {
        return Attribute::make(
            get: fn($value) => self::SEAT_TYPES[$value] ?? null,
            set: fn($value) => array_search($value, self::SEAT_TYPES)
        );
    }
}
