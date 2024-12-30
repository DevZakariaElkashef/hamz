<?php

namespace App\Http\Resources\Mall;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductInHomeResource extends JsonResource
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
            'product_image' => $this->image ? asset($this->image)  : '',
            'store_id' => $this->store->id ?? 0,
            'store_name' => $this->store->name ?? '',
            'store_image' => $this->store && $this->store->image ? asset($this->store->image)  : '',
            'is_added_to_favourite' => checkFavouriteProduct($request->user('sanctum'), $this->id),
        ];
    }
}
