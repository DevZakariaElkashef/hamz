<?php

namespace App\Repositories\Booth;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use DB;

class CartRepository
{
    public function update($request)
    {
        $user = $request->user();
        $product = Product::find($request->product_id);
        $cart = Cart::firstOrCreate(['user_id' => $user->id, 'store_id' => $product->store->id, 'app' => "booth"]);

        $item = $cart->items->where('product_id', $request->product_id)->first();

        if ($item) {
            $item->update([
                'qty' => $request->qty
            ]);
            $message = __("main.quantaty_updated");
        } else {
            $cart->items()->create([
                'product_id' => $request->product_id,
                'qty' => $request->qty,
                'app' => "booth"
            ]);
            $message = __("main.added_to_cart_success");
        }

        return $message;
    }

    public function delete($request)
    {
        $cartItem = CartItem::where('product_id', $request->product_id)->first();
        $cart = Cart::find($cartItem->cart_id);
        $cartItem->forceDelete();
        if($cart->items()->count() < 1){
            $cart->forceDelete();
        }
        return __("main.delete_successffully");
    }
}
