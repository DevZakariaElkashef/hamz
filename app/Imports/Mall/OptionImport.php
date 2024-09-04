<?php

namespace App\Imports\Mall;

use App\Models\Option;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class OptionImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            
            Option::create([
                'app' => 'mall',
                'value_ar' => $row['name_ar'],
                'value_en' => $row['name_en'],
                'attribute_id' => $row['attribute_id'],
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
            'attribute_id' => 'required|exists:attributes,id',
        ];
    }
}
