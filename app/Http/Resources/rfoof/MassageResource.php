<?php

namespace App\Http\Resources\rfoof;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MassageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'owner' => $this->checkOwner($request),
            'date' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'time' => Carbon::parse($this->created_at)->format('h:i:s A'),
            'time_ago' => Carbon::createFromTimeStamp(strtotime($this->created_at))->locale(app()->getLocale())->diffForHumans(),


            // 'type' => $this->type,
            // 'user_name' => $this->user->name,
            // 'user_id' => $this->user_id,
            // 'user_image' => $this->user->image,
            // 'seller_id' => $this->seller_id,
            // 'seller_name' => $this->seller ? $this->seller->name : "",
            // 'seller_image' => $this->seller ? $this->seller->image : "",
        ];
    }
}
