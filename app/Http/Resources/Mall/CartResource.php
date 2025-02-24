<?php

namespace App\Http\Resources\Mall;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'cart_id' => $this->id,
            'store_id' => $this->store_id,
            'store_name' => $this->store->name ?? '',
            'store_image' => $this->store->image ? asset($this->store->image) : '',
            'products' => ShowProductRecource::collection($this->getProducts($request)),
            'coupon' => $this->coupon ? $this->coupon->code : '',
            'delivery' => number_format($this->delivery, 2, '.', ''),
            'sub_total' => number_format($this->calcSubTotal(), 2, '.', ''),
            'tax_amount' => number_format($this->calcTax(), 2, '.', ''),
            'discount' => number_format($this->calcDiscount(), 2, '.', ''),
            'total' => number_format($this->calcTotal(), 2, '.', ''),
            'suggested_products' => $this->suggested_products,

        ];
    }

    private function getProducts($request)
    {
        return Product::whereIn('id', $this->items()->pluck('product_id')->toArray())->get();
    }

}
