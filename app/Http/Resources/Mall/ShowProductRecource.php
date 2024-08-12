<?php

namespace App\Http\Resources\Mall;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowProductRecource extends JsonResource
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
            'images' => $this->getImageCollection(),
            'logo' => $this->image ? asset($this->image) : '',
            'is_added_to_favourite' => checkFavouriteProduct($request->user('sanctum'), $this->id),
            'name' => $this->name ?? '',
            'price' => (string) $this->price,
            'offer' => (string) $this->getActiveOffer(),
            'description' => (string) $this->description,
            'qty_in_cart' => (int) getProductCountInCart($request->user('sanctum'), $this->id),
        ];
    }

    private function getImageCollection()
    {
        // Initialize an array to hold image URLs
        $images = [];

        // Check if there are images in the collection
        if ($this->images && $this->images->count() > 0) {
            // Add images from the collection
            $images = ImagePathRecource::collection($this->images)->toArray();
        }

        // Check if there's a single image and add it to the collection
        if ($this->image) {
            $images[] = asset($this->image);
        }

        // Return the collection of images, ensuring it's not empty
        return collect($images);
    }
}
