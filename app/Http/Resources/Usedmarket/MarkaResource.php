<?php

namespace App\Http\Resources\Usedmarket;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MarkaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->title(),
        ];
    }
}
