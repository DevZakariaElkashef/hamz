<?php

namespace App\Http\Resources\Mall;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsInStorePageResource extends JsonResource
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
            'name' => $this->name ?? '',
            'description' => $this->description ?? '',
            'image' => $this->image ? asset($this->image) : '',
            'is_added_to_favourite' => false,
            'price' => (string) $this->price ?? "0",
            'offer' => (string) $this->getActiveOffer() ?? "0"

        ];
    }
}
