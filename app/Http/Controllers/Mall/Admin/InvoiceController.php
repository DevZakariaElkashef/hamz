<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function show(Order $order)
    {
        return view('mall.orders.invoice', compact('order'));
    }
}
