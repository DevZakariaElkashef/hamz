<?php

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

function getProductCountInCart($cart, $id)
{
    if ($cart && $id) {
        $item = $cart->items->where('product_id', $id)->first();
        if ($item) {
            return $item->qty;
        }
        return 0;
    }
    return false;
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

function isActiveRoute($route, $params = [], $class = 'active')
{
    if (is_array($route)) {
        foreach ($route as $r) {
            if (Route::is($r) && empty(array_diff_assoc($params, request()->query()))) {
                return $class;
            }
        }
    } else {
        if (Route::is($route) && empty(array_diff_assoc($params, request()->query()))) {
            return $class;
        }
    }

    return '';
}


function isUserSubscribed($user, $app = null)
{
    if (!$user) {
        return false; // User not logged in
    }

    $subscriptions = $user->subscriptions();

    if ($subscriptions->count()) {
        return $subscriptions->where('status', 1)->where('app', $app)->exists();
    }

    return false; // No active subscription
}

