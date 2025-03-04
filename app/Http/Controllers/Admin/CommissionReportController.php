<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\CommissionTransactionController;
use App\Http\Controllers\Controller;
use App\Models\CommissionTransaction;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Http\Request;

class CommissionReportController extends Controller
{
    function commission_reports($app) {

        if (in_array($app, ['mall', 'booth'])) {
            $orders = Order::where('app', $app)->where('order_status_id', 4);
            if (auth()->user()->role->name == "seller"){
                $this_srore_id = '';
                $this_srore = Store::where('user_id', auth()->user()->id)
                ->where('app', $app)->first();
                if($this_srore){
                    $this_srore_id = $this_srore->id;
                }
                $orders = $orders->where('store_id', $this_srore_id);
            }
            $storesIds = $orders->pluck('store_id');
            $srores = Store::whereIn('id', $storesIds)->get();
            $totalIncome = $orders->sum('total');
            $orders = $orders->get();
            $totalCommission = $orders->sum('commission_value');
            return view('commissionReports.index', compact('srores', 'orders', 'totalIncome', 'totalCommission', 'app'));
        } elseif (in_array($app, ['rfoof', 'resale'])) {
            $commissions = CommissionTransaction::where('app', $app);
            $commissionsCount = $commissions->count();
            $totalAmountSum = $commissions->sum('total_amount');
            $commissions = $commissions->orderBy('time', 'DESC')->get();
            return view('commissionReports.index2', compact('commissions', 'commissionsCount', 'totalAmountSum', 'app'));
        }

    }
}
