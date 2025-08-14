<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'name' => $this->name,
            'city' => $this->city,
            'address_1' => $this->address_1,
            'postal_code' => $this->postal_code,
            'default' => $this->default,
            'country' => new CountryResource($this->whenLoaded('country')),
        ];
    }
}
