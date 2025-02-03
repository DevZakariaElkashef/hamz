<?php

namespace App\Http\Controllers\Booth\Api;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderStatus;
use App\Models\UserCoupon;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Booth\OrderResource;
use App\Http\Resources\Booth\ShowOrderResource;
use App\Http\Resources\Booth\OrderStatusResource;
use App\Http\Requests\Booth\Api\MakeOrderRrequest;
use App\Http\Requests\Mall\Api\CancleOrderRequest;
use App\Models\AppSetting;

class OrderController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $user = $request->user();

        $orders = Order::query()->booth();

        if ($request->filled('order_status_id')) {
            $orders->where('order_status_id', $request->order_status_id);
        }
        $orders = $orders->where('user_id', $user->id)->latest()->get();
        $orders = OrderResource::collection($orders);

        return $this->sendResponse(200, $orders);
    }

    public function show(Request $request, $order_id)
    {
        $language = app()->getLocale();
        $order = Order::select(
            'orders.*',
            'coupons.code AS coupon_code',
            "delivery_companies.name_$language AS delivery_company",
            "stores.name_$language AS store_name",
            "stores.image AS store_image"
        )
            ->with('orderItems.product')
            ->leftJoin('coupons', 'orders.coupon_id', '=', 'coupons.id')
            ->leftJoin('delivery_companies', 'orders.delivery_type', '=', 'delivery_companies.id')
            ->join('stores', 'orders.store_id', '=', 'stores.id')
            ->whereIn('orders.app', ['booth'])
            ->findOrFail($order_id);

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
        $management_ratio = AppSetting::select('value_ar')->where('app', 'booth')->first()->value_ar ?? 0;

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
            'management_ratio' => $management_ratio,

            'payment_type' => $request->payment_type,
            'payment_status' => 1, // will be paid
            'delivery_type' => $request->delivery_type,
            'order_status_id' => 1, // will be pending
            'transaction_id' => $request->transaction_id,

            'app' => 'booth'
        ]);
        if($cart->coupon_id){
            UserCoupon::create([
                'user_id' => $user->id,
                'coupon_id' => $cart->coupon_id,
                'app' => $cart->app,
            ]);
        }
        foreach ($cart->items as $item) {
            $order->orderItems()->create([
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'price' => Product::find($item->product_id)->calcPrice,
                'app' => 'booth'
            ]);
        }

        $cart->forceDelete();


        return $this->sendResponse(200, '', __("main.order_created_success"));
    }


    public function cancle(CancleOrderRequest $request)
    {
        $order = Order::find($request->order_id);

        if ($order->order_status_id == 5) {
            return $this->sendResponse(200, '', __("main.order_created_already"));
        }

        $order->update([
            'order_status_id' => 5,
            'cancle_reason_id' => $request->reason_id,
            'cancle_reason' => $request->reason_text ?? '',
        ]);

        return $this->sendResponse(200, '', __("main.order_cancleed_success"));
    }
}
