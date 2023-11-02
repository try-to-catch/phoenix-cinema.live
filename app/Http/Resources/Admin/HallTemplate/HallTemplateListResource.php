<?php

namespace App\Http\Resources\Admin\HallTemplate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HallTemplateListResource extends JsonResource
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
            'address' => $this->address,
            'number' => $this->number,
            'is_available' => $this->is_available,
            'seats_count' => $this->seats_count,
        ];
    }
}
