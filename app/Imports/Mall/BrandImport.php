<?php

namespace App\Imports\Mall;

use App\Models\Brand;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BrandImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            Brand::create([
                'app' => 'mall',
                'name_ar' => $row['name_ar'],
                'name_en' => $row['name_en'],
                'store_id' => $row['store_id'],
                'is_active' => $row['status']
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'store_id' => 'required|exists:stores,id',
            'status' => 'nullable|boolean',
        ];
    }
}
