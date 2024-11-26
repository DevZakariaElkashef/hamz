<?php

namespace App\Repositories\Booth;

use App\Models\Order;
use App\Models\OrderItem;
use App\Traits\ImageUploadTrait;

class OrderItemRepository
{
    public function calculateOrderTotals(Order $order)
    {
        // Calculate the subtotal (sum of all order items)
        $sub_total = $order->orderItems->sum(function ($item) {
            return $item->price * $item->qty; // Multiply price by quantity for each item
        });

        // Calculate the discount (assuming it is a fixed amount or percentage)
        $discount = $order->discount ?? 0; // Apply your discount logic here

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
    }

    public function createOrderItem(array $data)
    {
        // Create a new order item
        unset($data['_token']);
        return OrderItem::create($data);
    }

    public function updateOrderItem(OrderItem $orderItem, array $data)
    {
        // Update an existing order item
        unset($data['_token'], $data['_method']);
        $orderItem->update($data);
    }

    public function deleteOrderItem(OrderItem $orderItem)
    {
        // Delete the order item
        $orderItem->delete();
    }
}
