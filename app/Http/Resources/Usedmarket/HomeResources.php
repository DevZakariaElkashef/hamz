<?php

namespace App\Http\Resources\Usedmarket;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeResources extends JsonResource
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
            'name' => $this->title(),
            'image' => asset($this->image),
            'products' => ProductResource::collection(Product::where(['category_id' => $this->id, 'status' => 1, 'verify' => 1])->latest()->paginate(20)),
        ];
    }
}
