<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, HasUuids;

    public $timestamps = false;
    protected $fillable = [
        'name',
    ];

    public function scopeAdmin(Builder $query): Builder
    {
        return $query->where('name', 'admin');
    }
}
