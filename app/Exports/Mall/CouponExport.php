<?php

namespace App\Exports\Mall;

use App\Models\Coupon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CouponExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        return Coupon::filter($this->request)->mall()->get()->map(function ($coupon) {
            return [
                'id' => $coupon->id,
                'coupon' => $coupon->code,
                'discount' => $coupon->discount,
                'max_usage' => $coupon->max_usage,
                'used_times' => $coupon->users->count(),
                'start_date' => $coupon->start_date,
                'end_date' => $coupon->end_date,
            ];
        });
    }

    public function headings(): array
    {
        return [
            __("main.id"),
            __("main.code"),
            __("main.discount"),
            __("main.max_usage"),
            __('main.used_times'),
            __("main.start_date"),
            __('main.end_date')
        ];
    }
}
