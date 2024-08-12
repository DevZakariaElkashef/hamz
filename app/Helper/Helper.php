<?php

use App\Models\Cart;
use App\Models\Product;

function checkFavouriteProduct($user, $id)
{
    if ($user && $id) {
        return $user->favourites()->where("product_id", $id)->exists();
    }
    return false;
}

function checkFavouriteStore($user, $id)
{
    if ($user && $id) {
        return $user->favourites()->where("store_id", $id)->exists();
    }
    return false;
}

function getProductCountInCart($user, $id)
{
    if ($user && $id) {
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $item = $cart->items->where('product_id', $id)->first();
        if ($item) {
            return $item->qty;
        }
        return 0;
    }
    return false;
}


function checkUniqueStore($user, $prodID)
{
    $storeId = Product::find($prodID)->store->id;
    $unique = true;

    foreach ($user->cart->items as $item) {
        $id = $item->product->store->id;
        if ($id != $storeId) {
            $unique = false;
            break;
        }
    }

    return $unique;
}

function distance($lat1, $lng1, $lat2, $lng2)
{
    // Convert degrees to radians
    $lat1 = deg2rad($lat1);
    $lng1 = deg2rad($lng1);
    $lat2 = deg2rad($lat2);
    $lng2 = deg2rad($lng2);

    // Haversine formula
    $dLat = $lat2 - $lat1;
    $dLng = $lng2 - $lng1;

    $a = sin($dLat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dLng / 2) ** 2;
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    // Radius of the Earth in kilometers (mean radius)
    $earthRadius = 6371;

    // Calculate the distance
    $distance = $earthRadius * $c;

    return $distance;
}
