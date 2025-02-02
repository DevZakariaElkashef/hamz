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
        $wallet = 'watch_and_earn_wallet';
        $is_negative = 1;
        $symbol = '-';
        if ($wallet_type == '0') {
            $wallet = 'main_wallet';
            if ($this->type != '1') {
                $is_negative = 0;
                $symbol = '+';
            }
        }
        return [
            'type' => $this->type,
            'type_name' => __("main.$wallet" . "_tansaction_$this->type"),
            'amount' => $symbol . (string) $this->amount . ' ' . __('main.sar'),
            'is_negative' => $is_negative,
            'created_at' => $this->created_at
        ];
    }
}
