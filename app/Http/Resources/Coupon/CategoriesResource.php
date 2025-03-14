<?php

namespace App\Http\Resources\Coupon;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResource extends JsonResource
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
            'image' => $this->image ? asset($this->image): '',
            'couponsCount' => $this->coupons()->active()->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())->count() ?? 0
        ];
    }
}
