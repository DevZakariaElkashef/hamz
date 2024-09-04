<?php

namespace App\Exports\Mall;

use App\Models\Store;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StoreExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Store::filter($this->request)->mall()->get()->map(function ($store) {
            return [
                'id' => $store->id,
                'name' => $store->name,
                'description' => $store->description,
                'phone' => $store->phone,
                'address' => $store->address,
                'city' => $store->city->name ?? '',
                'owner' => $store->user->name ?? '',
                'section' => $store->section->name ?? '',
                'latitude' => $store->lat,
                'longitude' => $store->lng,
                'status' => $store->is_active ? __("mall.active") : __("mall.not_active"),
                'date' => $store->created_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            __("mall.id"),
            __("mall.name"),
            __("mall.description"),
            __("mall.phone"),
            __("mall.address"),
            __("mall.city"),
            __("mall.owner"),
            __("mall.section"),
            __("mall.lat"),
            __("mall.lng"),
            __("mall.status"),
            __("mall.date")
        ];
    }
}
