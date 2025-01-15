<?php

namespace App\Http\Resources\Booth;

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
        $order->day = __('main.' . $this->created_at->format('l'));
        $order->date = $this->created_at->format('d M Y');
        $order->status = OrderStatusResource::collection([$this->orderStatus])[0] ?? [];
        $order->delivery_company = $this->delivery_company ?? __("main.delivery_company_$this->delivery_type");
        $orderArray = parent::toArray($order);

        $user = request()->user();
        $order_rate = OrderStoreRating::booth()->where('rateable_type', 'App\Models\Order')
            ->where('rateable_id', $orderArray['id'])
            ->where('user_id', $user->id)
            ->select('id', 'rating', 'app', 'comment', 'user_id')->first();

        $store_rate = OrderStoreRating::booth()->where('rateable_type', 'App\Models\Store')
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
