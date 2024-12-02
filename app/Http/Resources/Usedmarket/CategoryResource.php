<?php

namespace App\Http\Resources\Usedmarket;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd('test');

        return [
            'id' => $this->id,
            'name' => $this->title(),
            'image' => asset('Admin/images/categories/'.$this->image),
            'subCategories' => SubCategoryResource::collection($this->subCategories)
        ];;
    }
}
