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
                'status' => $brand->is_active ? __("main.active") : __("main.not_active"),
                'date' => $brand->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('main.id'),
            __('main.name'),
            __('main.store'),
            __('main.status'),
            __('main.date'),
        ];
    }
}
