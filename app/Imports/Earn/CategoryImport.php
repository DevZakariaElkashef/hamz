<?php

namespace App\Imports\Earn;

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
                'app' => 'earn',
                'name_ar' => $row['name_ar'],
                'name_en' => $row['name_en'],
                'user_id' => $row['user_id'],
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
            'user_id' => 'required|exists:users,id',
            'status' => 'nullable|boolean',
        ];
    }
}
