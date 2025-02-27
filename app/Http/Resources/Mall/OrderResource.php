<?php

namespace App\Http\Resources\Mall;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'store_name' => $this->store ? $this->store->name : '',
            'store_image' => $this->store ? asset($this->store->image) : '',
            'status' => OrderStatusResource::collection([$this->orderStatus])[0] ?? [],
            'total' => (string) $this->total ?? '',
            'day' => __('main.' . $this->created_at->format('l')),
            'date' => $this->created_at->format('d M Y'),
            'app' => $this->app
        ];
    }
}
