<?php

namespace App\Http\Resources\Booth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartStoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'cart_id' => $this->id,
            'store_id' => $this->store->name ?? '',
            'store_name' => $this->store && $this->store->image ? asset($this->store->image) : '',
        ];
    }
}
