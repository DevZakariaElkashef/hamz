<?php

namespace App\Imports\Mall;

use App\Models\Store;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StoreImport implements ToCollection, WithHeadingRow, WithValidation
{
    
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            Store::create([
                'app' => 'mall',
                'name_ar' => $row['name_ar'],
                'name_en' => $row['name_en'],
                'description_ar' => $row['description_ar'],
                'description_en' => $row['description_en'],
                'lat' => $row['lat'],
                'lng' => $row['lng'],
                'address' => $row['address'],
                'phone' => $row['phone'],
                'section_id' => $row['section_id'],
                'city_id' => $row['city_id'],
                'user_id' => $row['user_id'],
                'pick_up' => $row['have_pick_up'],
                'delivery_type' => $row['hav_delivery'],
                'status' => $row['status']
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
            'lat' => 'required',
            'lng' => 'required',
            'address' => 'required|string',
            'phone' => 'required',
            'section_id' => 'required|exists:sections,id',
            'city_id' => 'required|exists:cities,id',
            'user_id' => 'required|exists:users,id',
            'status' => 'nullable|boolean',
            'have_pick_up' => 'nullable|boolean',
            'hav_delivery' => 'nullable|boolean',
        ];
    }
}
