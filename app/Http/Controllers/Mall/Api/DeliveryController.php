<?php

namespace App\Http\Controllers\Mall\Api;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mall\Api\CalcDeliveryRequest;
use App\Repositories\Mall\DeliveryRepository;

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
        $item = $user->cart->items->first();

        if ($item) {
            $store = $item->product->store;
            $data = $this->deliveryRepository->getDeliveryOptions($store);

            return $this->sendResponse(200, $data);
        }

        return $this->sendResponse(400, [], __("main.fill_cart_first"));
    }

    public function calcDelivery(CalcDeliveryRequest $request)
    {
        $user = $request->user();
        $user->load('cart.items.product.store');
        $item = $user->cart->items->first();

        $delivery = $this->deliveryRepository->calculateDelivery(
            $item->product->store,
            $request
        );

        $this->deliveryRepository->updateCartDelivery($user, $delivery);

        return $this->sendResponse(200, ['delivery' => $delivery]);
    }
}
