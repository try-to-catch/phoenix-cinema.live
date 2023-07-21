<?php

namespace App\Actions\Images;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class StoreThumbnailAction
{
    public function handle(UploadedFile|File $thumbnail, string $path, int $width = 320, int $height = 472): string
    {
        $filePath = "images/$path/";
        $fullPath = $filePath . $thumbnail->hashName();

        $image = Image::make($thumbnail)->fit($width, $height)->encode();
        Storage::disk('public')->put($fullPath, $image);

        return $fullPath;
    }
}
