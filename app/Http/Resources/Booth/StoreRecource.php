<?php

namespace App\Http\Resources\Booth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreRecource extends JsonResource
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
            'image' => $this->image ? asset($this->image) : '',
            'address' => $this->address ?? '',
        ];
    }
}
