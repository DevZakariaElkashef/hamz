<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $wallet_type = $request->query('wallet_type', '0');
        $wallet = ($wallet_type == '0') ? 'main_wallet' : 'watch_and_earn_wallet';
        $is_negative = $this->is_negative ?? (($wallet_type == '0' && $this->type != '1') ? 0 : 1);
        $symbol = ($is_negative) ? '-' : '+';

        return [
            'type' => $this->type,
            'type_name' => __("main.$wallet" . "_tansactions_$this->type"),
            'amount' => $symbol . (string) $this->amount . ' ' . __('main.sar'),
            'is_negative' => $is_negative,
            'created_at' => $this->created_at
        ];
    }
}
