<?php

namespace App\Http\Resources\Mall;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowStoreRecource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $products = $this->filterProductsByCategory($request);

        return [
            'images' => $this->getImageCollection(),
            'logo' => $this->getLogoUrl(),
            'name' => $this->name ?? '',
            'stars' => $this->getStars(), // You can make this dynamic later
            'is_added_to_favourite' => false,
            'address' => $this->address ?? '',
            'categories' => CategoriesInStorePageResource::collection($this->categories),
            'products' => ProductsInStorePageResource::collection($products)
        ];
    }

    private function filterProductsByCategory(Request $request)
    {
        if ($request->filled('category')) {
            return $this->products()->where('category_id', $request->category)->get();
        }

        return $this->products;
    }

    private function getImageCollection()
    {
        return $this->images && $this->images->count() > 0
            ? ImagePathRecource::collection($this->images)
            : collect([$this->image ? asset($this->image) : '']);
    }

    private function getLogoUrl()
    {
        return $this->image ? asset($this->image) : '';
    }

    private function getStars()
    {
        return '4.2'; // Make this dynamic later
    }
}
