<?php

namespace App\Repositories\Mall;

use App\Models\Cart;
use App\Models\Product;

class CartRepository
{
    public function update($request)
    {
        $user = $request->user();
        $product = Product::find($request->product_id);
        $cart = Cart::firstOrCreate(['user_id' => $user->id, 'store_id' => $product->store->id]);

        $item = $cart->items->where('product_id', $request->product_id)->first();

        if ($item) {
            $item->update([
                'qty' => $request->qty
            ]);
            $message = __("main.quantaty_updated");
        } else {
            $cart->items()->create([
                'product_id' => $request->product_id,
                'qty' => $request->qty
            ]);
            $message = __("main.added_to_cart_success");
        }

        return $message;
    }

    public function delete($request)
    {
        $cart = Cart::find($request->cart_id);
        $cart->items()->where('product_id', $request->product_id)->forceDelete();
        return __("main.delete_successffully");
    }
}
