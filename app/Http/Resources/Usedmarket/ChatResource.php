<?php

namespace App\Http\Resources\Usedmarket;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'type' => $this->type,
            'user_name' => $this->user->name,
            'user_id' => $this->user_id,
            'user_image' => $this->user->image,
            'seller_id' => $this->seller_id,
            'seller_name' => $this->seller ? $this->seller->name : "",
            'seller_image' => $this->seller ? $this->seller->image : "",
            'product_id' => $this->product_id,
            'product_name' => $this->product->name(),
            'owner' => $this->checkOwner($request),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'time_ago' => Carbon::createFromTimeStamp(strtotime($this->created_at))->locale(app()->getLocale())->diffForHumans(),
        ];
    }
}
