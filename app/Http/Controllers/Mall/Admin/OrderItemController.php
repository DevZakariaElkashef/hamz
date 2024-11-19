<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use function PHPSTORM_META\map;

use App\Http\Controllers\Controller;
use App\Repositories\Mall\OrderItemRepository;

class OrderItemController extends Controller
{
    protected $orderItemRepository;

    public function __construct(OrderItemRepository $orderItemRepository)
    {
        $this->orderItemRepository = $orderItemRepository;
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // Create a new order item
        $orderItem = $this->orderItemRepository->createOrderItem([
            'order_id' => $request->id,
            'product_id' => $request->product_id,
            'qty' => $request->qty,
            'price' => $product->calc_price,
        ]);

        // Get the associated order
        $order = $orderItem->order;

        // Recalculate and update order totals
        $this->orderItemRepository->calculateOrderTotals($order);

        return back()->with('success', __('main.added_successfully'));
    }

    public function update(Request $request, $id)
    {
        $orderItem = OrderItem::findOrFail($id);

        // Update the order item
        $this->orderItemRepository->updateOrderItem($orderItem, $request->all());

        // Get the associated order
        $order = $orderItem->order;

        // Recalculate and update order totals
        $this->orderItemRepository->calculateOrderTotals($order);

        return back()->with('success', __('main.updated_successfully'));
    }

    public function destroy($id)
    {
        $orderItem = OrderItem::findOrFail($id);

        // Get the associated order
        $order = $orderItem->order;

        // Delete the order item
        $this->orderItemRepository->deleteOrderItem($orderItem);

        // Recalculate and update order totals
        $this->orderItemRepository->calculateOrderTotals($order);

        return back()->with('success', __('main.deleted_successfully'));
    }
}
