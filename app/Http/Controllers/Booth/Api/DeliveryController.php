<?php

namespace App\Http\Controllers\Booth\Api;

use App\Models\Cart;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Booth\Api\CalcDeliveryRequest;
use App\Repositories\Booth\DeliveryRepository;

class DeliveryController extends Controller
{
    use ApiResponse;

    protected $deliveryRepository;

    public function __construct(DeliveryRepository $deliveryRepository)
    {
        $this->deliveryRepository = $deliveryRepository;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $user->load('cart.items.product.store');
        $cart = $user->cart->first();
        $item = $cart?->items?->first() ?? null;

        if ($item) {
            $store = $item->product->store;
            $data = $this->deliveryRepository->getDeliveryOptions($store);

            return $this->sendResponse(200, $data);
        }

        return $this->sendResponse(400, [], __("main.fill_cart_first"));
    }

    public function calcDelivery(CalcDeliveryRequest $request)
    {
        $cart = Cart::findOrFail($request->cart_id);
        if ($cart) {
            $delivery = $this->deliveryRepository->calculateDelivery(
                $cart->store,
                $request
            );
            $this->deliveryRepository->updateCartDelivery($cart, $delivery);
            return $this->sendResponse(200, ['delivery' => $delivery]);
        }

        return $this->sendResponse(400, [], __("main.fill_cart_first"));
    }
}
