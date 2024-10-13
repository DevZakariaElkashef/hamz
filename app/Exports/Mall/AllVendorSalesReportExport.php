<?php

namespace App\Exports\Mall;

use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AllVendorSalesReportExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request  = $request;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $locale = app()->getLocale(); // Get current locale

        $sales = OrderItem::with(['product.category.store'])
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('stores', 'categories.store_id', '=', 'stores.id')
            ->select(
                "stores.name_{$locale} as store_name", // Dynamically select store name based on locale
                DB::raw('SUM(order_items.qty) as total_quantity'),
                DB::raw('SUM(order_items.price * order_items.qty) as total_sales')
            )
            ->groupBy("stores.name_{$locale}") // Group by the selected store name column
            ->get()
            ->map(function ($item) {
                return [
                    'store' =>  $item->store_name,
                    'total_qty' =>  $item->total_quantity,
                    'total_sale' =>  $item->total_sales,
                ];
            });

            return $sales;
    }

    public function headings(): array
    {
        return [
            __('main.store'),
            __('main.Quantity_Sold'),
            __('main.Total_Sales')
        ];
    }
}
