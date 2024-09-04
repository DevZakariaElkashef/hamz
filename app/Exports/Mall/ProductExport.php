<?php

namespace App\Exports\Mall;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        return Product::filter($this->request)->mall()->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'offer' => $product->offer,
                'start_offer_date' => $product->start_offer_date,
                'end_offer_date' => $product->end_offer_date,
                'qty' => $product->qty,
                'brand' => $product->brand->name ?? '',
                'category' => $product->category->name ?? '',
                'store' => $product->store->name ?? '',
                'section' => $product->store->section->name ?? '',
                'status' => $product->is_active ? __("mall.active") : __("mall.not_active"),
                'date' => $product->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('mall.id'),
            __('mall.name'),
            __('mall.description'),
            __('mall.price'),
            __('mall.offer'),
            __('mall.start_offer_date'),
            __('mall.end_offer_date'),
            __('mall.qty'),
            __('mall.parent_category'),
            __('mall.brand'),
            __('mall.category'),
            __('mall.store'),
            __('mall.section'),
            __('mall.status'),
            __('mall.date'),
        ];
    }
}
