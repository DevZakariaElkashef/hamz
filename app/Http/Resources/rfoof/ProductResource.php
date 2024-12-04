<?php

namespace App\Http\Resources\rfoof;

use Carbon\Carbon;
use App\Models\Image;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($request->user()) {
            $favourite = Favourite::where(['product_id' => $this->id, 'user_id' => $request->user()->id])->first();
            $favouriteType = $favourite ? true : false;
        } else {
            $favouriteType = false;
        }
        return [
            'id' => $this->id,
            'unique_number' => $this->unique_number,
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'description_ar' => $this->description_ar ?? "",
            'description_en' => $this->description_en ?? "",
            'name' => $this->name(),
            'desc' => $this->desc() ?? "",
            'phone' => $this->phone ?? "",
            'price' => $this->price,
            'lat' => $this->lat ?? "",
            'long' => $this->long ?? "",
            'address_ar' => $this->address_ar ?? "",
            'address_en' => $this->address_en ?? "",
            'direction_id' => $this->direction_id ?? 0,
            'direction' => $this->direction ? $this->direction->name() : "",
            'misahuh' => $this->misahuh ?? "",
            'count_rooms' => $this->count_rooms ?? "",
            'number_bathrooms' => $this->number_bathrooms ?? "",
            'count_floor' => $this->count_floor ?? "",
            'number_councils' => $this->number_councils ?? "",
            'number_halls' => $this->number_halls ?? "",
            'street_view' => $this->street_view ?? "",
            'location' => $this->location ?? "",
            'number_parties_seeking' => $this->number_parties_seeking ?? "",
            'width' => $this->width ?? "",
            'height' => $this->height ?? "",
            'floor_number' => $this->floor_number ?? "",
            'property_age' => $this->property_age ?? "",
            'user_id' => $this->user_id,
            'adsOwner' => $this->user->name ?? "",
            'adsOwnerImage' => $this->user->image ?? "",
            'category_id' => $this->category_id,
            'category' => $this->category?->title() ?? "",
            'sub_category_id' => $this->sub_category_id ?? 0,
            'subCategory' => $this->subCategory?->title() ?? "",
            'country_id' => $this->country_id ?? 0,
            'country' => $this->country?->title() ?? "",
            'product_status_id' => $this->product_status_id ?? 0,
            'ProductSatus' => $this->ProductSatus?->title() ?? "",
            'city_id' => $this->city_id ?? 0,
            'city' => $this->city?->title() ?? "",
            'neighborhood' => $this->neighborhood ?? "",
            'image' => Image::where('product_id', $this->id)->first() ? asset('Admin/images/ads/' . Image::where('product_id', $this->id)->first()->image) : "",
            'images' => ProductImagesResource::collection(Image::where('product_id', $this->id)->get(['id', 'image'])),
            'favourite' => $favouriteType,
            'license_number' => $this->license_number ?? "",
            'apartments_number' => $this->apartments_number ?? "",
            'adsOwnerDetials' => UserResource::make($this->user),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'time_ago' => Carbon::createFromTimeStamp(strtotime($this->created_at))->locale(app()->getLocale())->diffForHumans(),
        ];
    }
}
