<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Screening extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'movie_id',
        'hall_id',
        'start_time',
        'end_time',
        'standard_seat_price',
        'premium_seat_price',
    ];

    protected $casts = [
        'start_time' => 'datetime:Y-m-d H:i',
        'end_time' => 'datetime:Y-m-d H:i',
    ];

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function hall(): BelongsTo
    {
        return $this->belongsTo(Hall::class);
    }

    public function standardSeatPrice(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['standard_seat_price_in_cents'] / 100,
            set: fn($value) => ['standard_seat_price_in_cents' => $value * 100],
        );
    }

    public function premiumSeatPrice(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['premium_seat_price_in_cents'] / 100,
            set: fn($value) => ['premium_seat_price_in_cents' => $value * 100],
        );
    }

    public function isOver(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => Carbon::parse($attributes['end_time'])->isPast(),
        );
    }
}
