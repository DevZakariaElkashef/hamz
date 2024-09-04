<?php

namespace App\Exports\Mall;

use App\Models\Brand;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BrandExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        return Brand::filter($this->request)->mall()->get()->map(function ($brand) {
            return [
                'id' => $brand->id,
                'name' => $brand->name,
                'store' => $brand->store->name ?? '',
                'status' => $brand->is_active ? __("mall.active") : __("mall.not_active"),
                'date' => $brand->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('mall.id'),
            __('mall.name'),
            __('mall.store'),
            __('mall.status'),
            __('mall.date'),
        ];
    }
}
