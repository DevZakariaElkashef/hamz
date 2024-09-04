<?php

namespace App\Exports\Mall;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoryExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        return Category::filter($this->request)->mall()->get()->map(function ($cateogry) {
            return [
                'id' => $cateogry->id,
                'name' => $cateogry->name,
                'parent' => $cateogry->parent->name ?? '',
                'store' => $cateogry->store->name ?? '',
                'status' => $cateogry->is_active ? __("mall.active") : __("mall.not_active"),
                'date' => $cateogry->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('mall.id'),
            __('mall.name'),
            __('mall.parent_category'),
            __('mall.store'),
            __('mall.status'),
            __('mall.date'),
        ];
    }
}
