<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    // Report of all product sales
    public function allProductSalesReport()
    {
        $sales = OrderItem::with('product')
            ->select('product_id', DB::raw('SUM(qty) as total_quantity'), DB::raw('SUM(price * qty) as total_sales'))
            ->groupBy('product_id')
            ->get();

        return view('mall.reports.all_product_sales', compact('sales'));
    }

    // Report of sales for all vendors (stores)
    public function allVendorSalesReport()
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
            ->get();

        return view('mall.reports.all_vendor_sales', compact('sales'));
    }


    // Report of all order statuses
    public function orderStatusReport()
    {
        $orders = Order::with('orderStatus')
            ->join('order_statuses', 'orders.order_status_id', '=', 'order_statuses.id')
            ->select('order_statuses.name_ar AS status', DB::raw('COUNT(*) as total_orders'))
            ->groupBy('status')
            ->get();

        return view('mall.reports.order_status_report', compact('orders'));
    }

    // Report of all order details
    public function allOrderDetailsReport()
    {
        $orders = OrderItem::with(['order', 'order.store', 'order.user'])->whereHas('order.store', function ($store) {
            $store->where('app', 'mall');
        })->get();


        return view('mall.reports.all_order_details', compact('orders'));
    }

    // Report of delayed shipments
    public function delayedShipmentsReport()
    {
        $delayedOrders = Order::where('status', 'pending')
            ->where('shipment_delay', '>', 0) // Assuming you have a shipment_delay column
            ->get();

        return view('reports.delayed_shipments', compact('delayedOrders'));
    }

    // Customer Reports

    // Report of customer activities
    public function customerActivityReport()
    {
        $customers = User::whereHas('orders')->withCount('orders')->get();

        return view('mall.reports.customer_activity', compact('customers'));
    }


    // Report of low stock alerts
    public function lowStockAlertsReport()
    {
        $products = Product::where('qty', '<', 10) // Assuming stock threshold is 10
            ->get();

        return view('mall.reports.low_stock_alerts', compact('products'));
    }

    // Return/Refund Reports

    // Report of all returns
    public function returnsReport()
    {
        $returns = OrderItem::where('is_returned', true) // Assuming you have an is_returned column
            ->with('product')
            ->get();

        return view('reports.returns', compact('returns'));
    }

    // Financial Performance Reports

    // Profit and loss report
    public function profitAndLossReport()
    {
        // Calculation logic here
        // Assuming you have cost and revenue fields to calculate profit and loss
        $profitAndLoss = [
            'total_profit' => 10000, // Placeholder calculation
            'total_loss' => 5000
        ];

        return view('reports.profit_and_loss', compact('profitAndLoss'));
    }
}
