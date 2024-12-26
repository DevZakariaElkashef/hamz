<?php

namespace App\Http\Resources\Mall;

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
            'store_id' => $this->store->id ?? 0,
            'store_name' => $this->store->name ?? '',
            'store_image' => $this->store && $this->store->image ? asset($this->store->image) : '',
            'app' => $this->app ?? '',
        ];
    }
}
