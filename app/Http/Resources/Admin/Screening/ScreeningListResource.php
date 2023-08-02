<?php

namespace App\Http\Resources\Admin\Screening;

use App\Http\Resources\Admin\Hall\HallResource;
use App\Http\Resources\Admin\Movie\MovieSummaryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScreeningListResource extends JsonResource
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
            'start_time' => $this->start_time->format('Y-m-d H:i'),
            'end_time' => $this->end_time->format('Y-m-d H:i'),
            'is_over' => $this->is_over,
            'movie' => MovieSummaryResource::make($this->movie),
            'hall' => HallResource::make($this->hall)
        ];
    }
}
