<?php

namespace App\Http\Resources\rfoof;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'title' => $this->title(),
            'message' => $this->message(),
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d h:i:s'),
            'time_ago' => Carbon::createFromTimeStamp(strtotime($this->created_at))->locale(app()->getLocale())->diffForHumans(),
        ];
    }
}
