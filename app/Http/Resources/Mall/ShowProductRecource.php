<?php

namespace App\Http\Resources\Mall;

use App\Models\Cart;
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
            'images' => $this->getImageCollection($request),
            'logo' => $this->image ? asset($this->image) : '',
            'is_added_to_favourite' => checkFavouriteProduct($request->user('sanctum'), $this->id),
            'name' => $this->name ?? '',
            'price' => (string) $this->price,
            'offer' => (string) $this->getActiveOffer(),
            'description' => (string) $this->description,
            'qty_in_cart' => (int) getProductCountInCart(Cart::where('store_id', $this->store->id)->first(), $this->id),
            // 'options' =>
        ];
    }

    private function getImageCollection($request)
    {
        // Initialize an array to hold image URLs
        $images = [];

        // Check if there are images in the collection
        if ($this->images && $this->images->count()) {
            // Add images from the collection
            $images = ImagePathRecource::collection($this->images)->toArray($request);
        }

        // Check if there's a single image and add it to the collection
        if (!$this->image) {
            $images[] = [
                'id' => 1, // does not matter this id if just for the shape of the image path resource
                'path' => asset($this->image)
            ];
        }

        // Return the collection of images, ensuring it's not empty
        return collect($images);
    }
}
