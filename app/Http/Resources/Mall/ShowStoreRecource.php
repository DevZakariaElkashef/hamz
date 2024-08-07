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
        return [
            'images' => ImagePathRecource::collection($this->images),
            'logo' => $this->image ? asset($this->image) : '',
            'name' => ''
        ];
    }
}
