<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Category;
use App\Models\Section;
use App\Models\Store;
use Auth;
use DB;
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
        $sectionsCount = Section::query();

        // fetch olny vendor's data
        if ($roleID == 3) {
            $store = Store::active()->mall()->where('user_id', $user->id)->first();
            $categoriesCount = $categoriesCount->where('store_id', $store->id);

            $productsCount = $productsCount->whereHas('store', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });


            $ordersCount = $ordersCount->where('store_id', $store->id);

            $couponsCount = $couponsCount->where('store_id', $store->id);
        }

        $categoriesCount = $categoriesCount->active()->mall()->count();
        $productsCount = $productsCount->active()->mall()->count();
        $ordersCount = $ordersCount->mall()->count();
        $couponsCount = $couponsCount->mall()->active()->count();
        $sectionsCount = $sectionsCount->mall()->active()->count();

        $mostStors = $this->getStoresWithOrders('DESC');
        $lessStors = $this->getStoresWithOrders('ASC');

        $lessProducts = $this->getProductsWithOrders('ASC');
        $mostProducts = $this->getProductsWithOrders('DESC');


        return view("mall.index", compact(
            'categoriesCount',
            'productsCount',
            'ordersCount',
            'couponsCount',
            'sectionsCount',
            'mostStors',
            'lessStors',
            'lessProducts',
            'mostProducts',
        ));
    }


    private function getStoresWithOrders($orderBy = 'desc', $limit = 5)
    {
        // $local = app()->getLocale();
        $data = Store::where('app', 'mall')
        ->withCount('orders')
        ->orderBy('orders_count', $orderBy)
        ->limit($limit)
        ->get();
        return $data;
    }

    private function getProductsWithOrders($orderBy = 'desc', $storeId= null, $limit = 5)
    {
        // $local = app()->getLocale();
        $user = Auth::user();
        $userId = $user->id;
        $data = Product::where('app', 'mall');
        if ($user->role->name == 'seller') {
            $data = $data->whereHas('store', function ($query) use ($userId) {
                $query->where('stores.user_id', $userId);
            });
        }
        $data = $data->withSum('orderItems', 'qty')
        ->orderBy('order_items_sum_qty', $orderBy)
        ->limit($limit)
        ->get();
        return $data;
    }
}
