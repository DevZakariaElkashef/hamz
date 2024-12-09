<?php

namespace App\Http\Resources\Mall;

use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'attribute_name' => $this->name ?? '',
            'option_name' => Option::find($this->pivot->option_id)->value ?? '',
            'price' => $this->pivot->additional_price ?? '',
            'is_required' => !$this->pivot->is_required ?? false
        ];
    }
}
