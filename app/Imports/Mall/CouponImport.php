<?php

namespace App\Imports\Mall;

use App\Models\Coupon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CouponImport implements ToCollection, WithValidation, WithHeadingRow
{
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {

            Coupon::create([
                'app' => 'mall',
                'code' => $row['code'],
                'discount' => $row['discount'],
                'max_usage' => $row['max_usage'],
                'start_date' => $row['start_date'],
                'end_date' => $row['end_date'],
                'is_active' => $row['status']
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:255',
            'discount' => 'required|numeric',
            'max_usage' => 'required|integer',
            'status' => 'required|boolean',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];
    }
}
