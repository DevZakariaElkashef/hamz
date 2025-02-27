<?php

namespace App\Http\Resources\Earn;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WithdrowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->id,
            'withdraw_type' => $this->withdraw_type,
            'amount' => (string) $this->amount . ' ' . __('main.sar'),
            'date' => (string) $this->created_at->format('d/m/Y - h:i a'),
            'status' => (string) $this->statusName,
            'status_id' => (int) $this->status,
        ];
    }
}
