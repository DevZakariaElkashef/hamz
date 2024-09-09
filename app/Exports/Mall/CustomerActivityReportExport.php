<?php

namespace App\Exports\Mall;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerActivityReportExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        return User::whereHas('orders')->withCount('orders')->get()->map(function ($user) {
            return [
                'client' =>  $user->name,
                'phone' =>  $user->phone,
                'orders' =>  $user->orders_count,
            ];
        });
    }

    public function headings(): array
    {
        return [
            __("mall.client"),
            __("mall.phone"),
            __("mall.total_orders")
        ];
    }


}
