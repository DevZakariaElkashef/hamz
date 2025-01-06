<?php

namespace App\Http\Resources\Earn;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            "id"=> $this->id,
            "title"=> $this->title,
            "path"=> $this->path,
            "thumbnail"=> $this->thumbnail,
            "category_id"=> $this->category_id,
            "seller_id"=> $this->seller_id,
            "reword_amount"=> $this->reword_amount,
            "is_active"=> $this->is_active,
            "duration"=> $this->duration,
            "app"=> $this->app,
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at
        ];
    }
}
