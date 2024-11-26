<?php

namespace App\Http\Controllers\Booth\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function show(Order $order)
    {
        return view('booth.orders.invoice', compact('order'));
    }
}
