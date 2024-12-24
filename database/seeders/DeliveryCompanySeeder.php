<?php

namespace Database\Seeders;

use App\Models\DeliveryCompany;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeliveryCompany::create([
            'name_ar' => 'شركة توصيل هنعمل معاها لينك المفروض يعنى',
            'name_en' => 'Delivery Company 1',
            'color' => '#212121'
        ]);

        DeliveryCompany::create([
            'name_ar' => 'شركة توصيل هنعمل معاها لينك المفروض يعنى',
            'name_en' => 'Delivery Company 2',
            'color' => '#212151'
        ]);
    }
}
