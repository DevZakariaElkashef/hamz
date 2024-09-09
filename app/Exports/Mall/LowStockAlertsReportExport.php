<?php

namespace App\Exports\Mall;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LowStockAlertsReportExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::filter($this->request)->mall()->where('qty', '<', 10)->get()->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'status' => $product->is_active ? __("mall.active") : __("mall.not_active"),
                'qty' => $product->qty,
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('mall.id'),
            __('mall.name'),
            __("mall.status"),
            __('mall.qty')
        ];
    }
}
