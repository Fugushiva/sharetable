<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AnnonceResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'schedule' => $this->schedule,
            'price' => $this->price,
            'cuisine' => $this->cuisine,
            'max_guest' => $this->max_guest,
            'create_ad' => $this->create_ad,
            'pictures' => $this->pictures,
            'delete_ad' => $this->delete_ad,
        ];
    }
}
