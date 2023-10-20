<?php

namespace App\Services;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Model;

class MovieBannerService
{
    protected const DEFAULT_WIDTH = 1050;

    protected const DEFAULT_HEIGHT = 400;

    public function __construct(protected ImageService $imageService)
    {
    }

    /**
     * Create a banner for a movie.
     */
    public function create(Movie $movie, array $data, int $width = self::DEFAULT_WIDTH, int $height = self::DEFAULT_HEIGHT): Model
    {
        $data['image'] = $this->imageService->store($data['image'], 'banners/movies', $width, $height);

        return $movie->banner()->create([
            'image' => $data['image'],
            'description' => $data['description'],
            'fact' => $data['fact'],
        ]);
    }

    public function update(Movie $movie, array $data, int $width = self::DEFAULT_WIDTH, int $height = self::DEFAULT_HEIGHT): Model
    {
        $data['image'] = $this->imageService->update($data['image'], $movie->banner->image, $width, $height);

        return $movie->banner->update([
            'image' => $data['image'],
            'description' => $data['description'],
            'fact' => $data['fact'],
        ]);
    }

    public function destroy(Movie $movie): bool
    {
        return $this->imageService->destroy($movie->banner->image);
    }
}
