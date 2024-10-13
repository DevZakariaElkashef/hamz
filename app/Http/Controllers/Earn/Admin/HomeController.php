<?php

namespace App\Http\Controllers\Earn\Admin;

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
        $customerRating = floor(OrderReview::avg('stars'));
        $totalSale = Order::earn()->where('order_status_id', 4)->sum('total');
        $allSales = Order::earn()->where('order_status_id', 4)->count();

        $categoriesCount = Category::active()->earn()->count();
        $productsCount = Product::active()->earn()->count();
        $ordersCount = Order::earn()->count();
        $couponsCount = Coupon::earn()->active()->count();



        return view("earn.index", compact('customerRating'));
    }
}
