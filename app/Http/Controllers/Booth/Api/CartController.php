<?php

namespace App\Http\Controllers\Booth\Api;

use App\Models\Cart;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Booth\CartResource;
use App\Repositories\Booth\CartRepository;
use App\Http\Resources\Booth\CartStoreResource;
use App\Http\Requests\Booth\Api\ClearCartRequest;
use App\Http\Requests\Booth\Api\UpdateCartRequest;
use App\Http\Requests\Booth\Api\DeleteItemFromCartRequest;

class CartController extends Controller
{
    use ApiResponse;

    public $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $data = CartStoreResource::collection($user->boothCart);
        return $this->sendResponse(200, $data);
    }

    public function show(Request $request, $id)
    {

        $cart = Cart::find($id);
        if (!$cart) {
            return $this->sendResponse(404, __('main.cart_not_found'));
        }
        $data = new CartResource($cart);
        return $this->sendResponse(200, $data);
    }

    public function update(UpdateCartRequest $request)
    {
        $message = $this->cartRepository->update($request);
        return $this->sendResponse(200, '', $message);
    }

    public function delete(DeleteItemFromCartRequest $request)
    {
        $message = $this->cartRepository->delete($request);
        return $this->sendResponse(200, '', $message);
    }


    public function destroy(ClearCartRequest $request)
    {
        $cart = Cart::find($request->cart_id);
        $cart->items()->forceDelete();
        $cart->forceDelete();
        return $this->sendResponse(200, '', __("main.delete_successffully"));
    }
}
