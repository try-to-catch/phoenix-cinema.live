<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Screening\ScreeningWithMovieResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileOrderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'screening' => ScreeningWithMovieResource::make($this->screening)->resolve(),
            'seat_count' => $this->seats_count,
            'isCompleted' => $this->isCompleted,
            'created_at' => $this->created_at,
        ];
    }
}
