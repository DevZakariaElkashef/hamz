<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class OrderItemController extends Controller
{

    public function store(Request $request)
    {
        dd($request->all());
    }
    public function update(Request $request, $id)
    {
        // Find the specific OrderItem
        $orderItem = OrderItem::find($id);

        // Update the OrderItem details based on the request data
        $orderItem->update($request->all());

        // Get the associated order
        $order = $orderItem->order;

        // Calculate the subtotal (sum of all order items)
        $sub_total = $order->orderItems->sum(function ($item) {
            return $item->price * $item->qty; // Multiply price by quantity for each item
        });

        // Calculate the discount if any (assuming it is a fixed amount or percentage)
        $discount = $order->discount ?? 0; // You can add your own discount logic here

        // Apply tax (e.g., 15%)
        $tax = ($sub_total - $discount) * 0.15;

        // Calculate the final total (subtotal - discount + tax + delivery fee)
        $total = ($sub_total - $discount) + $tax + $order->delivery_fee;

        // Update the order with the new values
        $order->update([
            'sub_total' => $sub_total,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $total,
        ]);

        // Return back with success message
        return back()->with('success', __('mall.updated_successffully'));
    }
}
