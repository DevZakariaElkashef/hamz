<?php

namespace App\Http\Resources\Earn;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "name"=> $this->name,
            "image"=> asset($this->image),
            "url"=> $this->url,
            "is_fixed"=> $this->is_fixed,
            "is_active"=> $this->is_active,
            "app"=> $this->app,
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at
        ];
    }
}
