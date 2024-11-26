<?php

namespace App\Imports\Booth;

use App\Models\City;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CityImport implements ToCollection, WithHeadingRow, WithValidation
{

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {

            City::create([
                'app' => 'booth',
                'name_ar' => $row['name_ar'],
                'name_en' => $row['name_en'],
                'is_active' => $row['status']
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'status' => 'nullable|boolean',
        ];
    }
}
