<?php

namespace App\Http\Controllers\Mall\Api;

use App\Models\Cart;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mall\Api\CalcDeliveryRequest;
use App\Repositories\Mall\DeliveryRepository;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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
        // Validate the cart_id
        try {
            $validated = $request->validate([
                'cart_id' => [
                    'required',
                    Rule::exists('carts', 'id')->where(function ($query) use ($request) {
                        $query->where('user_id', $request->user()->id)
                            ->where('app', 'mall');
                    }),
                ],
            ]);
        }  catch (ValidationException $e) {
            $errorMessage = $e->validator->errors()->first();
            return response()->json([
                'status' => false,
                'message' => $errorMessage,
                'data' => ''
            ], 400);
        }

        $cart = Cart::find($request->cart_id);
        if ($cart) {
            $store = $cart->store;
            $types = $this->deliveryRepository->getDeliveryOptions($store);
            $data = [];
            if($request->lat && $request->lng){
                foreach ($types as $type) {
                    $request->delivery_type = $type['id'];
                    $delivery = $this->deliveryRepository->calculateDelivery(
                        $store,
                        $request
                    );
                    $type['delivery'] = number_format($delivery, 2, '.', '');
                    $data [] = $type;
                }
            }else{
                $data = $types;
            }
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
