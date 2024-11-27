<?php

namespace Database\Seeders;

use App\Models\ProductStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name_ar' => 'متوفر', 'name_en' => 'Available'],
            ['name_ar' => 'غير متوفر', 'name_en' => 'Out of Stock'],
            ['name_ar' => 'قيد الانتظار', 'name_en' => 'Pending'],
            ['name_ar' => 'مستبدل', 'name_en' => 'Replaced'],
            ['name_ar' => 'مستعاد', 'name_en' => 'Returned'],
        ];

        ProductStatus::insert($data);
    }
}
