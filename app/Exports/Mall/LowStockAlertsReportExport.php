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
                'status' => $product->is_active ? __("main.active") : __("main.not_active"),
                'qty' => $product->qty,
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('main.id'),
            __('main.name'),
            __("main.status"),
            __('main.qty')
        ];
    }
}
