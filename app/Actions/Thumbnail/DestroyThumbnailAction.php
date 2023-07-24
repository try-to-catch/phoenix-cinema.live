<?php

namespace App\Actions\Thumbnail;

use Illuminate\Support\Facades\Storage;

class DestroyThumbnailAction
{
    public function __construct(public StoreThumbnailAction $storeThumbnailAction)
    {
    }

    public function handle(string $thumbnail): bool
    {
        return Storage::disk('public')->delete($thumbnail);
    }
}
