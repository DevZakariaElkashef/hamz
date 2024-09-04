<?php

namespace App\Exports\Mall;

use App\Models\Attribute;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttributeExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        return Attribute::filter($this->request)->mall()->get()->map(function ($attribute) {
            return [
                'id' => $attribute->id,
                'name' => $attribute->name,
                'status' => $attribute->is_active ? __("mall.active") : __("mall.not_active"),
                'date' => $attribute->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('mall.id'),
            __('mall.name'),
            __('mall.status'),
            __('mall.date'),
        ];
    }
}
