<?php

namespace App\Http\Resources\Earn;

use Carbon\Carbon;
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
            "store_url"=> $this->store_url ,
            "store"=> $this->store_id ? [
                'id' => $this->store->id ?? '',
                'name' => $this->store->name ?? '',
                'image' => $this->store ? asset($this->store->image) : '',
                'app' => $this->store->app ?? '',
            ] : null,
            "reword_amount"=> $this->reword_amount,
            "is_active"=> $this->is_active,
            "duration"=> $this->duration,
            "app"=> $this->app,
            "created_at"=> $this->created_at,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d h:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d h:i:s'),
        ];
    }
}
