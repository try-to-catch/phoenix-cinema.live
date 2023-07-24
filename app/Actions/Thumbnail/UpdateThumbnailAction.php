<?php

namespace App\Actions\Thumbnail;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

class UpdateThumbnailAction
{
    public function __construct(
        public StoreThumbnailAction   $storeThumbnailAction,
        public DestroyThumbnailAction $destroyThumbnailAction
    )
    {
    }

    public function handle(UploadedFile|File|null $thumbnail, string $oldThumbnailPath, int $width = 320, int $height = 472): string
    {
        if (is_null($thumbnail)) {
            return $oldThumbnailPath;
        }

        $this->destroyThumbnailAction->handle($oldThumbnailPath);

        $path = str_replace('images/', '', dirname($oldThumbnailPath));

        return $this->storeThumbnailAction->handle($thumbnail, $path, $width, $height);
    }
}
