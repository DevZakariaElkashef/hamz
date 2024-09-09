<?php

namespace App\Exports\Mall;

use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AllProductSalesReportExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        return  OrderItem::with('product')
            ->select('product_id', DB::raw('SUM(qty) as total_quantity'), DB::raw('SUM(price * qty) as total_sales'))
            ->groupBy('product_id')
            ->get()
            ->map(function ($item) {
                return [
                    'product' => $item->product->name,
                    'total_qty' => $item->total_quantity,
                    'total_sale' => $item->total_sales,
                ];
            });
    }

    public function headings(): array
    {
        return [
            __("mall.product"),
            __('mall.Quantity_Sold'),
            __("mall.Total_Sales")
        ];
    }
}
