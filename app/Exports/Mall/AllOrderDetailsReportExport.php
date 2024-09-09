<?php

namespace App\Exports\Mall;

use App\Models\OrderItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AllOrderDetailsReportExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        return OrderItem::with(['order', 'order.store', 'order.user'])
            ->whereHas('order.store', function ($store) {
                $store->where('app', 'mall');
            })
            ->when($this->request->filled('start_at'), function ($query) {
                $query->whereHas('order', function ($order) {
                    $order->whereDate('created_at', '>=', $this->request->start_at);
                });
            })
            ->when($this->request->filled('end_at'), function ($query) {
                $query->whereHas('order', function ($order) {
                    $order->whereDate('created_at', '<=', $this->request->end_at);
                });
            })
            ->when($this->request->filled('section_id'), function ($query) {
                $query->whereHas('order.store', function ($store) {
                    $store->where('section_id', $this->request->section_id);
                });
            })
            ->when($this->request->filled('store_id'), function ($query) {
                $query->whereHas('order', function ($order) {
                    $order->where('store_id', $this->request->store_id);
                });
            })
            ->get()
            ->map(function ($item) {
                return [
                    'order' =>  $item->order_id,
                    'product' =>  $item->product->name,
                    'qty' =>  $item->qty,
                    'price' =>  $item->price,
                    'total' =>  $item->order->sub_total,
                ];
            });
    }

    public function headings(): array
    {
        return [
            __("mall.Order_number"),
            __('mall.product'),
            __('mall.qty'),
            __('mall.price'),
            __('mall.total')
        ];
    }
}
