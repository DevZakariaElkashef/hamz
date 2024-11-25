<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categoriesCount = Category::active()->mall()->count();
        $productsCount = Product::active()->mall()->count();
        $ordersCount = Order::mall()->count();
        $couponsCount = Coupon::mall()->active()->count();

        return view("mall.index", compact('categoriesCount', 'productsCount', 'ordersCount', 'couponsCount'));
    }
}
