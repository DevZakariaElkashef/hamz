<?php

namespace App\Repositories\Booth;

use App\Models\DeliveryCompany;

class DeliveryRepository
{
    public function getDeliveryOptions($store)
    {
        $data = DeliveryCompany::all()
            ->map(function ($company) {
                return [
                    'id' => $company->id,
                    'name' => $company->{'name_' . app()->getLocale()},
                    'color' => str_replace('#', '', $company->color)
                ];
            })
            ->toArray();

        if ($store->delivery_type) {
            $data[] = ['id' => 3, 'name' => 'store_delivery', 'color' => 'b2b2b2'];
        }

        if ($store->pickup) {
            $data[] = ['id' => 4, 'name' => 'pick up from the store', 'color' => 'b2b2b2'];
        }

        return $data;
    }

    public function calculateDelivery($store, $request)
    {
        $delivery = 0;
        $deliveryType = $request->delivery_type;

        switch ($deliveryType) {
            case 1:
                // Delivery type 1
                $delivery = 0; // Example value, replace with actual logic
                break;
            case 2:
                // Delivery type 2
                $delivery = 0; // Example value, replace with actual logic
                break;
            case 3:
                if ($store->storeDelivery) {
                    $delivery = $store->calcDeliveryValue(['lat' => $request['lat'], 'lng' => $request['lng']])['delivery'];
                }
                break;
        }

        return $delivery;
    }


    public function updateCartDelivery($cart, $delivery)
    {
        if ($cart) {
            $cart->delivery = $delivery;
            $cart->save();

            return true;
        }

        return false;
    }
}
