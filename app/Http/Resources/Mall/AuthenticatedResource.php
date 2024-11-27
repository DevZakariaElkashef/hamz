<?php

namespace App\Http\Resources\Mall;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthenticatedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? '',
            'email' => $this->email ?? '',
            'phone' => (string) $this->phone ?? '',
            'code' => (string) $this->code ?? '',
            'advertisercharacter_id' => (int) $this->advertisercharacter_id ?? 0,
            'advertisercharacter_name' => $this->advertisercharacter_id ? $this->advertisercharacte->name : '',
            'image' => $this->image ? asset($this->image) : '',
            'wallet' => (string) $this->wallet ?? 0,
            'token' => 'Bearer ' . $this->createToken('Api')->plainTextToken
        ];
    }
}
