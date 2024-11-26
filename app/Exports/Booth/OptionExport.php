<?php

namespace App\Exports\Booth;

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
        return Option::filter($this->request)->booth()->get()->map(function ($option) {
            return [
                'id' => $option->id,
                'name' => $option->value,
                'attribute' => $option->attribute->name,
                'status' => $option->is_active ? __("main.active") : __("main.not_active"),
                'date' => $option->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('main.id'),
            __('main.name'),
            __('main.attribute'),
            __('main.status'),
            __('main.date'),
        ];
    }
}
