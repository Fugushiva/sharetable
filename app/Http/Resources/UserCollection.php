<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "email" => $this->email,
            "firstname" => $this->firstname,
            "lastname" => $this->lastname,
            "language_id" => $this->language_id,
            "profile_picture" => $this->profile_picture,
            "country_id" => $this->country_id,
            "city_id" => $this->city_id,
        ];
    }
}
