<?php

namespace App\Http\Resources\Mall;

use App\Models\CancleOrderReason;
use App\Models\OrderStoreRating;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($order)
    {
        $orderArray = parent::toArray($order);
        $orderArray->day = __('main.' . $orderArray->created_at->format('l'));
        $orderArray->date = $orderArray->created_at->format('d M Y');
        $orderArray->status = OrderStatusResource::collection([$this->orderStatus])[0] ?? [];
        $orderArray->delivery_company = $orderArray->delivery_company ?? __("main.delivery_company_$orderArray->delivery_type");

        $user = request()->user();
        $order_rate = OrderStoreRating::mall()->where('rateable_type', 'App\Models\Order')
            ->where('rateable_id', $orderArray['id'])
            ->where('user_id', $user->id)
            ->select('id', 'rating', 'app', 'comment', 'user_id')->first();

        $store_rate = OrderStoreRating::mall()->where('rateable_type', 'App\Models\Store')
            ->where('rateable_id', $orderArray['store_id'])
            ->where('user_id', $user->id)
            ->select('id', 'rating', 'app', 'comment', 'user_id')->first();

        $cancle_order_reasons = CancleOrderReason::all()->map(function ($reason) {
            return [
                'id' => $reason->id,
                'name' => $reason->{'name_' . app()->getLocale()}
            ];
        });
        $products = $this->orderItems->map(function ($item) {
            return $item->product;
        });

        unset($orderArray['order_items']);

        return array_merge($orderArray, [
            'products' => ShowProductRecource::collection($products),
            'order_rate' => $order_rate,
            'store_rate' => $store_rate,
            'cancle_order_reasons' => $cancle_order_reasons,
        ]);
    }
}
