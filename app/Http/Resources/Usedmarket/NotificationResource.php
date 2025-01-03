<?php

namespace App\Http\Resources\Usedmarket;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'title' => $this->title(),
            'message' => $this->message(),
            'status' => $this->status,
            'created_at' => $this->created_at
        ];
    }
}
