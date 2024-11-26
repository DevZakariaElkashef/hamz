<?php

namespace App\Exports\Booth;

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
        return Attribute::filter($this->request)->booth()->get()->map(function ($attribute) {
            return [
                'id' => $attribute->id,
                'name' => $attribute->name,
                'status' => $attribute->is_active ? __("main.active") : __("main.not_active"),
                'date' => $attribute->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('main.id'),
            __('main.name'),
            __('main.status'),
            __('main.date'),
        ];
    }
}
