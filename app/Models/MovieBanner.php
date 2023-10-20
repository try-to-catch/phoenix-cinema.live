<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieBanner extends Model
{
    use HasFactory, HasUuids;

    public $timestamps = false;

    protected $fillable = [
        'image',
        'description',
        'fact',
    ];

    public function imagePath(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => '/storage/'.$attributes['image'],
        );
    }
}
