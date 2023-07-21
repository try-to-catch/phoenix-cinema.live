<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hall extends Model
{
    use HasFactory, HasUuids;

    protected $casts = [
        'is_available' => 'boolean',
        'is_preset' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'is_available',
        'is_preset',
    ];

    public function seats(): hasMany
    {
        return $this->hasMany(Seat::class);
    }
}