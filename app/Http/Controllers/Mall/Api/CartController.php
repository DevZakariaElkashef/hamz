<?php

namespace App\Http\Controllers\Mall\Api;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mall\Api\DeleteItemFromCartRequest;
use App\Http\Requests\Mall\Api\UpdateCartRequest;
use App\Http\Resources\Mall\CartResource;
use App\Repositories\Mall\CartRepository;
use App\Traits\ApiResponse;

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
        $data = new CartResource($user);
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


    public function destroy(Request $request)
    {
        $request->user()->cart->items()->forceDelete();
        $request->user()->cart->update([
            'coupon_id' => null
        ]);
        return $this->sendResponse(200, '', __("mall.delete_successffully"));
    }
}
