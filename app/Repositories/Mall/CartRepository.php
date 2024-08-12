<?php

namespace App\Repositories\Mall;

use App\Models\Cart;

class CartRepository
{
    public function update($request)
    {
        $user = $request->user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $item = $cart->items->where('product_id', $request->product_id)->first();

        if ($item) {
            $item->update([
                'qty' => $request->qty
            ]);
            $message = __("mall.quantaty_updated");
        } else {
            $cart->items()->create([
                'product_id' => $request->product_id,
                'qty' => $request->qty
            ]);
            $message = __("mall.added_to_cart_success");
        }

        return $message;
    }

    public function delete($request)
    {
        $user = $request->user();
        $user->cart->items()->where('product_id', $request->product_id)->forceDelete();
        return __("mall.delete_successffully");
    }
}
