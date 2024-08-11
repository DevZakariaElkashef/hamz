<?php

namespace App\Http\Controllers\Mall\Api;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mall\Api\UpdateCartRequest;

class CartController extends Controller
{
    public function update(UpdateCartRequest $request)
    {
        $user = $request->user();
        dd($user);

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        dd($cart);

    }
}
