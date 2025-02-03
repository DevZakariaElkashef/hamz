<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\User;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        if ($order->payment_type == '1' && $order->payment_status == '1') {
            $user = User::findOrFail($order->user_id);

            $user->update([
                'wallet' => $user->wallet - $order->total
            ]);
        }
    }
}
