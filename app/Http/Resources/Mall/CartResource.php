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
            'store_name' => $this->getStoreData($request)['name'],
            'store_image' => $this->getStoreData($request)['image'],
            'products' => ShowProductRecource::collection($this->getProducts($request)),
            'sub_total' => number_format($this->getCart($request)->calcSubTotal($request->user('sanctum')), 2, '.', ''),
            'coupon' => $this->getCart($request)->coupon ? $this->getCart($request)->coupon->code : '',
            'tax_amount' => number_format($this->getCart($request)->calcTax($request->user('sanctum')), 2, '.', ''),
            'discount' => number_format($this->getCart($request)->calcDiscount($request->user('sanctum')), 2, '.', ''),
            'delivery' => number_format($this->cart->delivery, 2, '.', ''),
            'total' => number_format($this->getCart($request)->calcTotal($request->user('sanctum')), 2, '.', ''),


        ];
    }

    private function getProducts($request)
    {
        return Product::whereIn('id', $this->getCart($request)->items()->pluck('product_id')->toArray())->get();
    }

    private function getStoreData($request)
    {
        $cart = $this->getCart($request);
        $item = $cart->items->first();
        if ($item) {
            return [
                'name' => $item->product->store->name,
                'image' => asset($item->product->store->image),
            ];
        }
        return [
            'name' => '',
            'image' => '',
        ];
    }

    private function getCart($request)
    {
        $user = $request->user('sanctum');
        return Cart::firstOrCreate(['user_id' => $user->id]);
    }
}
