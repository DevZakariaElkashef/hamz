<?php

namespace App\Imports\Mall;

use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CategoryImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            Category::create([
                'app' => 'mall',
                'name_ar' => $row['name_ar'],
                'name_en' => $row['name_en'],
                'store_id' => $row['store_id'],
                'parent_id' => $row['parent_id'],
                'is_active' => $row['status']
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'parent_id' => 'nullable|exists:categories,id',
            'store_id' => 'required|exists:stores,id',
            'status' => 'nullable|boolean',
        ];
    }
}
