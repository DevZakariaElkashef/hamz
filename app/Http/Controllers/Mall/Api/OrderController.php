<?php

namespace App\Http\Controllers\Mall\Api;

use App\Models\Cart;
use App\Models\Order;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Mall\OrderResource;
use App\Http\Requests\Mall\Api\MakeOrderRrequest;
use App\Http\Resources\Mall\OrderStatusResource;
use App\Http\Resources\Mall\ShowOrderResource;
use App\Models\OrderStatus;

class OrderController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $user = $request->user();

        $orders = Order::query();

        if ($request->filled('order_status_id')) {
            $orders->where('order_status_id', $request->order_status_id);
        }
        $orders = $orders->where('user_id', $user->id)->latest()->get();
        $orders = OrderResource::collection($orders);

        return $this->sendResponse(200, $orders);
    }

    public function show(Request $request, Order $order)
    {
        $order = new ShowOrderResource($order);

        return $this->sendResponse(200, $order);
    }

    public function viewStatuses(Request $request)
    {
        $statuses = OrderStatus::active()->get();
        $statuses = OrderStatusResource::collection($statuses);
        return $this->sendResponse(200, $statuses);
    }

    public function store(MakeOrderRrequest $request)
    {
        $user = $request->user();
        $cart = Cart::find($request->cart_id);

        $order = Order::create([
            'user_id' => $user->id,
            'address' => $request->address,
            'store_id' => $cart->store_id,
            'lat' => $request->lat,
            'lng' => $request->lng,

            'sub_total' => $cart->calcSubTotal(),
            'tax' => $cart->calcTax(),
            'discount' => $cart->calcDiscount(),
            'delivery' => $cart->delivery,
            'coupon_id' => $cart->coupon_id,
            'total' => $cart->calcTotal(),

            'payment_type' => $request->payment_type,
            'payment_status' => 1, // will be paid
            'delivery_type' => $request->delivery_type,
            'order_status_id' => 1, // will be pending
            'transaction_id' => $request->transaction_id,

            'app' => 'mall'
        ]);

        foreach ($cart->items as $item) {
            $order->orderItems()->create([
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'price' => $item->price,
                'app' => 'mall'
            ]);
        }

        $cart->forceDelete();


        return $this->sendResponse(200, '', __("mall.order_created_success"));
    }
}
