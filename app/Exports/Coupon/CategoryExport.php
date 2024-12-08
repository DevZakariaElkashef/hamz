<?php

namespace App\Exports\Coupon;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

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
        return Category::filter($this->request)->copuons()->get()->map(function ($cateogry) {
            return [
                'id' => $cateogry->id,
                'name' => $cateogry->name,
                'parent' => $cateogry->parent->name ?? '',
                'store' => $cateogry->store->name ?? '',
                'status' => $cateogry->is_active ? __("main.active") : __("main.not_active"),
                'date' => $cateogry->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('main.id'),
            __('main.name'),
            __('main.parent_category'),
            __('main.store'),
            __('main.status'),
            __('main.date'),
        ];
    }
}
