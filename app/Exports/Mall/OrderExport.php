<?php

namespace App\Exports\Mall;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public $request;

    public function __construct($reqeust)
    {
        $this->request = $reqeust;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::filter($this->request)->get()->map(function ($order) {
            return [
                'id' => $order->id,
                'date' => $order->created_at,
                'client_name' => $order->user->name ?? '',
                'client_phone' => $order->user->phone ?? '',
                'payment_method' => $order->payment_method ?? '',
                'payment_status' => $order->payment_condition,
                'total' => $order->total,
                'status' => $order->orderStatus->name ?? '',
                'section' => $order->store->section->name ?? '',
                'store' => $order->store->name ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('mall.id'),
            __('mall.date'),
            __('mall.client'),
            __('mall.phone'),
            __('mall.payment_method'),
            __('mall.payment_status'),
            __('mall.total'),
            __('mall.status'),
            __('mall.section'),
            __('mall.store'),
        ];
    }
}
