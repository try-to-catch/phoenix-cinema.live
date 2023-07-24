<?php

namespace App\Services;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ThumbnailService
{
    /**
     * Store a thumbnail in storage.
     */
    public function store(UploadedFile|File $thumbnail, string $directory, int $width = 320, int $height = 472): string
    {
        $path = "images/$directory/" . $thumbnail->hashName();

        $image = Image::make($thumbnail)->fit($width, $height)->encode();
        Storage::disk('public')->put($path, $image);

        return $path;
    }

    /**
     * Update a thumbnail in storage unless the new thumbnail is null.
     */
    public function update(UploadedFile|File|null $thumbnail, string $oldThumbnailPath, int $width = 320, int $height = 472): string
    {
        if (is_null($thumbnail)) {
            return $oldThumbnailPath;
        }

        $this->destroy($oldThumbnailPath);

        $path = str_replace('images/', '', dirname($oldThumbnailPath));

        return $this->store($thumbnail, $path, $width, $height);
    }

    /**
     * Delete a thumbnail from storage.
     */
    public function destroy(string $thumbnail): bool
    {
        return Storage::disk('public')->delete($thumbnail);
    }
}
