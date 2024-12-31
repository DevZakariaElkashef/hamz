<?php

namespace App\Http\Resources\rfoof;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'comment' => $this->comment ?? '',
            'rate' => $this->rate,
            'product_id' => $this->product_id,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name ?? '',
            'user_image' => $this->user && $this->user->image ? asset($this->user->image) : '',
            'app' => $this->app ?? '',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
