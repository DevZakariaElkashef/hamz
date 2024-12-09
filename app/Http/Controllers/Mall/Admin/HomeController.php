<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $roleID = $user->role_id;

        $categoriesCount = Category::query();
        $productsCount = Product::query();
        $ordersCount = Order::query();
        $couponsCount = Coupon::query();

        // fetch olny vendor's data
        if ($roleID == 3) {
            $categoriesCount = $categoriesCount->whereHas('store', function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('role_id', 3);
                });
            });

            $productsCount = $productsCount->whereHas('category', function ($category) {
                $category->whereHas('store', function ($query) {
                    $query->whereHas('user', function ($query) {
                        $query->where('role_id', 3);
                    });
                });
            });


            $ordersCount = $ordersCount->whereHas('store', function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('role_id', 3);
                });
            });

            $couponsCount = $couponsCount->whereHas('store', function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('role_id', 3);
                });
            });
        }

        $categoriesCount = $categoriesCount->active()->mall()->count();
        $productsCount = $productsCount->active()->mall()->count();
        $ordersCount = $ordersCount->mall()->count();
        $couponsCount = $couponsCount->mall()->active()->count();

        return view("mall.index", compact('categoriesCount', 'productsCount', 'ordersCount', 'couponsCount'));
    }
}
