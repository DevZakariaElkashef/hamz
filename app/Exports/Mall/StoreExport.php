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
                'status' => $store->is_active ? __("main.active") : __("main.not_active"),
                'date' => $store->created_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            __("main.id"),
            __("main.name"),
            __("main.description"),
            __("main.phone"),
            __("main.address"),
            __("main.city"),
            __("main.owner"),
            __("main.section"),
            __("main.lat"),
            __("main.lng"),
            __("main.status"),
            __("main.date")
        ];
    }
}
