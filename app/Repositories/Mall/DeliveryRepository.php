<?php

namespace App\Repositories\Mall;

class DeliveryRepository
{
    public function getDeliveryOptions($store)
    {
        $data = [
            ['id' => 1, 'name' => 'company one'],
            ['id' => 2, 'name' => 'company two']
        ];

        if ($store->delivery_type) {
            $data[] = ['id' => 3, 'name' => 'store_delivery'];
        }

        if ($store->pickup) {
            $data[] = ['id' => 4, 'name' => 'pick up from the store'];
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


    public function updateCartDelivery($user, $delivery)
    {
        $user->cart->update([
            'delivery' => $delivery
        ]);

        return true;
    }
}
