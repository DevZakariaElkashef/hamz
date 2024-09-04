<?php

namespace App\Exports\Mall;

use App\Models\Option;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OptionExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        return Option::filter($this->request)->mall()->get()->map(function ($option) {
            return [
                'id' => $option->id,
                'name' => $option->value,
                'attribute' => $option->attribute->name,
                'status' => $option->is_active ? __("mall.active") : __("mall.not_active"),
                'date' => $option->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('mall.id'),
            __('mall.name'),
            __('mall.attribute'),
            __('mall.status'),
            __('mall.date'),
        ];
    }
}
