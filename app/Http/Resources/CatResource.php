<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'breed' => $this->breed,
            'date_of_birth' => $this->date_of_birth,
            'weight' => $this->weight,
            'user_id' => $this->user_id,
        ];
    }
}
