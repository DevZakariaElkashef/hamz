<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Http\Request;

class CommissionReportController extends Controller
{
    function commission_reports($app) {
        $orders = Order::where('app', $app)->where('order_status_id', 4);
        $storesIds = $orders->pluck('store_id');
        $srores = Store::whereIn('id', $storesIds)->get();
        $totalIncome = $orders->sum('total');
        $orders = $orders->get();
        $totalCommission = $orders->sum('commission_value');
        return view('commissionReports.index', compact('srores', 'orders', 'totalIncome', 'totalCommission'));
    }
}
