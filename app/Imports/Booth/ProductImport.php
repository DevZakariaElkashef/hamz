<?php

namespace App\Imports\Booth;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            // Function to convert Excel serial date to Carbon date
            $excelDateToCarbon = function ($serial) {
                // Excel's base date is 1899-12-30
                return Carbon::createFromFormat('Y-m-d', Carbon::createFromFormat('Y-m-d', '1899-12-30')->addDays($serial)->format('Y-m-d'));
            };

            // Convert and format start_offer_date
            $startOfferDate = $excelDateToCarbon($row['start_offer_date'])->format('Y-m-d');

            // Convert and format end_offer_date
            $endOfferDate = $excelDateToCarbon($row['end_offer_date'])->format('Y-m-d');

            // Create the product with formatted dates
            Product::create([
                'app' => 'booth',
                'name_ar' => $row['name_ar'],
                'name_en' => $row['name_en'],
                'description_ar' => $row['description_ar'],
                'description_en' => $row['description_en'],
                'price' => $row['price'],
                'offer' => $row['offer'],
                'start_offer_date' => $startOfferDate,
                'end_offer_date' => $endOfferDate,
                'qty' => $row['qty'],
                'brand_id' => $row['brand_id'],
                'category_id' => $row['category_id'],
                'is_active' => $row['status']
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'price' => 'required',
            'offer' => 'required',
            'start_offer_date' => 'required',
            'end_offer_date' => 'required',
            'qty' => 'required|integer',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'status' => 'nullable|boolean',
        ];
    }
}
