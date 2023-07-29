<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class HallTemplate extends Model
{
    use HasFactory, HasUuids;

    protected $casts = [
        'is_available' => 'boolean',
    ];

    protected $fillable = [
        'title',
        'is_available',
    ];

    public function seats(): MorphMany
    {
        return $this->morphMany(Seat::class, 'seatable');
    }
}
