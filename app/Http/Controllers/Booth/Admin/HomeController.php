<?php

namespace App\Http\Controllers\Booth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categoriesCount = Category::active()->booth()->count();
        $productsCount = Product::active()->booth()->count();
        $ordersCount = Order::booth()->count();
        $couponsCount = Coupon::booth()->active()->count();

        return view("booth.index", compact('categoriesCount', 'productsCount', 'ordersCount', 'couponsCount'));
    }
}
