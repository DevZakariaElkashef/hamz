<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderReview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->authorize('view-mall-dashboard.index');
        $customerRating = floor(OrderReview::avg('stars'));
        $totalSale = Order::mall()->where('order_status_id', 4)->sum('total');
        $allSales = Order::mall()->where('order_status_id', 4)->count();

        $categoriesCount = Category::active()->mall()->count();
        $productsCount = Product::active()->mall()->count();
        $ordersCount = Order::mall()->count();
        $couponsCount = Coupon::mall()->active()->count();



        return view("mall.index", compact('customerRating'));
    }
}
