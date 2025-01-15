<?php

namespace App\Http\Resources\Coupon;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponsResource extends JsonResource
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
            'code ' => $this->code ?? '',
            'discount' => $this->discount ?? '',
            'max_usage' => $this->max_usage ?? '',
            'title' => $this->title ?? '',
            'description' => $this->description ?? '',
            'app ' => $this->app ?? '',
            'image' => $this->image ? asset($this->image): '',
            'couponsCount' => $this->coupon()->active()->count() ?? 0
        ];
    }
}
