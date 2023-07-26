<?php

namespace App\Http\Resources\Admin\Hall;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HallListResource extends JsonResource
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
            'title' => $this->title,
            'is_available' => $this->is_available,
            'seats_count' => $this->seats_count,
        ];
    }
}