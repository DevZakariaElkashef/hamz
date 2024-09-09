<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Store;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Mall\OrderStatusReportExport;
use App\Exports\Mall\AllVendorSalesReportExport;
use App\Exports\Mall\LowStockAlertsReportExport;
use App\Exports\Mall\AllOrderDetailsReportExport;
use App\Exports\Mall\AllProductSalesReportExport;
use App\Exports\Mall\CustomerActivityReportExport;

class ReportController extends Controller
{
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    // Report of all product sales
    public function allProductSalesReport(Request $request)
    {
        $sales = OrderItem::with('product')
            ->select('product_id', DB::raw('SUM(qty) as total_quantity'), DB::raw('SUM(price * qty) as total_sales'))
            ->groupBy('product_id')
            ->paginate($request->per_page ?? $this->limit);

        return view('mall.reports.products.all_product_sales', compact('sales'));
    }

    public function searchAllProductSalesReport(Request $request)
    {
        $sales = OrderItem::with('product')
            ->whereHas('product', function ($product) use ($request) {
                $product->where('name_ar', 'like', "%$request->search%")
                    ->orWhere('name_en', 'like', "%$request->search%");
            })
            ->select('product_id', DB::raw('SUM(qty) as total_quantity'), DB::raw('SUM(price * qty) as total_sales'))
            ->groupBy('product_id')
            ->paginate($request->per_page ?? $this->limit);

        return view('mall.reports.products.all_product_sales_table', compact('sales'))->render();
    }

    public function exportAllProductSalesReport(Request $request)
    {
        return Excel::download(new AllProductSalesReportExport($request), 'product_reports.xlsx');
    }



    // Report of sales for all vendors (stores)
    public function allVendorSalesReport(Request $request)
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
            ->paginate($request->per_page ?? $this->limit);

        return view('mall.reports.vendors.all_vendor_sales', compact('sales'));
    }

    public function searchAllVendorSalesReport(Request $request)
    {
        $locale = app()->getLocale(); // Get current locale

        $sales = OrderItem::with(['product.category.store'])
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('stores', 'categories.store_id', '=', 'stores.id')
            ->whereHas('product.category.store', function ($store) use ($request) {
                $store->where('name_ar', 'like', "%$request->search%")
                    ->orWhere('name_en', 'like', "%$request->search%");
            })
            ->select(
                "stores.name_{$locale} as store_name", // Dynamically select store name based on locale
                DB::raw('SUM(order_items.qty) as total_quantity'),
                DB::raw('SUM(order_items.price * order_items.qty) as total_sales')
            )
            ->groupBy("stores.name_{$locale}") // Group by the selected store name column
            ->paginate($request->per_page ?? $this->limit);

        return view('mall.reports.vendors.all_vendor_sales_table', compact('sales'))->render();
    }

    public function exportAllVendorSalesReport(Request $request)
    {
        return Excel::download(new AllVendorSalesReportExport($request), 'vendor_reports.xlsx');
    }


    // Report of all order statuses
    public function orderStatusReport(Request $request)
    {
        $orders = Order::with('orderStatus')
            ->join('order_statuses', 'orders.order_status_id', '=', 'order_statuses.id')
            ->when($request->filled('start_at'), function ($query) use ($request) {
                $query->whereDate('orders.created_at', '>=', $request->start_at);
            })
            ->when($request->filled('end_at'), function ($query) use ($request) {
                $query->whereDate('orders.created_at', '<=', $request->end_at);
            })
            ->when($request->filled('section_id'), function ($query) use ($request) {
                $query->wherehas('store', function ($store) use ($request) {
                    $store->where('section_id', $request->section_id);
                });
            })
            ->when($request->filled('store_id'), function ($query) use ($request) {
                $query->where('store_id', $request->store_id);
            })
            ->select('order_statuses.name_ar AS status', DB::raw('COUNT(*) as total_orders'))
            ->groupBy('status')
            ->paginate($request->per_page ?? $this->limit);


        $sections = Section::mall()->active()->get();
        $stores = Store::mall()->active()->get();

        return view('mall.reports.orders.order_status_report', compact('orders', 'stores', 'sections'));
    }

    // Report of all order statuses
    public function exportOrderStatusReport(Request $request)
    {
        return Excel::download(new OrderStatusReportExport($request), 'order_statuses.xlsx');
    }




    // Report of all order details
    public function allOrderDetailsReport(Request $request)
    {
        $orders = OrderItem::with(['order', 'order.store', 'order.user'])
            ->whereHas('order.store', function ($store) {
                $store->where('app', 'mall');
            })
            ->when($request->filled('start_at'), function ($query) use ($request) {
                $query->whereHas('order', function ($order) use ($request) {
                    $order->whereDate('created_at', '>=', $request->start_at);
                });
            })
            ->when($request->filled('end_at'), function ($query) use ($request) {
                $query->whereHas('order', function ($order) use ($request) {
                    $order->whereDate('created_at', '<=', $request->end_at);
                });
            })
            ->when($request->filled('section_id'), function ($query) use ($request) {
                $query->whereHas('order.store', function ($store) use ($request) {
                    $store->where('section_id', $request->section_id);
                });
            })
            ->when($request->filled('store_id'), function ($query) use ($request) {
                $query->whereHas('order', function ($order) use ($request) {
                    $order->where('store_id', $request->store_id);
                });
            })
            ->paginate($request->per_page ?? $this->limit);
        $sections = Section::mall()->active()->get();
        $stores = Store::mall()->active()->get();


        return view('mall.reports.orders.all_order_details', compact('orders', 'sections', 'stores'));
    }

    public function searchAllOrderDetailsReport(Request $request)
    {
        $orders = OrderItem::with(['order', 'order.store', 'order.user'])->whereHas('order.store', function ($store) use ($request) {
            $store->where('app', 'mall');
        })->where(function ($q) use ($request) {
            $q->whereHas('product', function ($product) use ($request) {
                $product->where('name_ar', 'like', "%$request->search%")
                    ->orWhere('name_en', 'like', "%$request->search%");
            });
        })->paginate($request->per_page ?? $this->limit);

        return view('mall.reports.orders.all_order_details_table', compact('orders'))->render();
    }

    public function exportAllOrderDetailsReport(Request $request)
    {
        return Excel::download(new AllOrderDetailsReportExport($request), 'orders_details.xlsx');
    }

    // Report of customer activities
    public function customerActivityReport(Request $request)
    {
        $customers = User::whereHas('orders')->withCount('orders')->paginate($request->per_page ?? $this->limit);

        return view('mall.reports.customers.customer_activity', compact('customers'));
    }

    public function searchCustomerActivityReport(Request $request)
    {
        $customers = User::whereHas('orders')->where(function ($user) use ($request) {
            $user->where('name', 'like', "%$request->search%")
                ->orWhere('phone', 'like', "%$request->search%");
        })->withCount('orders')->paginate($request->per_page ?? $this->limit);

        return view('mall.reports.customers.customer_activity_table', compact('customers'))->render();
    }

    public function exportCustomerActivityReport(Request $request)
    {
        return Excel::download(new CustomerActivityReportExport($request), 'clients.xlsx');
    }


    // Report of low stock alerts
    public function lowStockAlertsReport(Request $request)
    {
        $products = Product::filter($request)->mall()->where('qty', '<', 10)->get();
        $sections = Section::mall()->active()->get();
        $stores = Store::mall()->active()->get();
        $categories = Category::mall()->active()->get();
        $brands = Brand::mall()->active()->get();

        return view('mall.reports.products.low_stock_alerts', compact('products', 'sections', 'stores', 'categories', 'brands'));
    }
    public function searchLowStockAlertsReport(Request $request)
    {
        $products = Product::search($request)->mall()->where('qty', '<', 10) // Assuming stock threshold is 10
            ->get();
        return view('mall.reports.products.low_stock_alerts_table', compact('products'));
    }
    public function exportLowStockAlertsReport(Request $request)
    {
        return Excel::download(new LowStockAlertsReportExport($request), 'low_stock.xlsx');
    }
}
