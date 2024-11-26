<?php

namespace App\Exports\Booth;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderStatusReportExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::with('orderStatus')
        ->join('order_statuses', 'orders.order_status_id', '=', 'order_statuses.id')
        ->when($this->request->filled('start_at'), function ($query) {
            $query->whereDate('orders.created_at', '>=', $this->request->start_at);
        })
        ->when($this->request->filled('end_at'), function ($query) {
            $query->whereDate('orders.created_at', '<=', $this->request->end_at);
        })
        ->when($this->request->filled('section_id'), function ($query) {
            $query->wherehas('store', function ($store) {
                $store->where('section_id', $this->request->section_id);
            });
        })
        ->when($this->request->filled('store_id'), function ($query) {
            $query->where('store_id', $this->request->store_id);
        })
        ->select('order_statuses.name_ar AS status', DB::raw('COUNT(*) as total_orders'))
        ->groupBy('status')
        ->get()
        ->map(function ($order) {
            return [
                'order' => $order->status,
                'total' => $order->total_orders,
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('main.status'),
            __('main.total_orders')
        ];
    }
}
