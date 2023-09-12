<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Hall extends Model
{
    use HasFactory, HasUuids;

    public $timestamps = false;

    protected $fillable = [
        'number',
        'address',
        'screening_id',
    ];

    protected $casts = [
        'number' => 'integer',
    ];

    public function seats(): MorphMany
    {
        return $this->morphMany(Seat::class, 'seatable');
    }

    public function screening(): BelongsTo
    {
        return $this->belongsTo(Screening::class);
    }
}
