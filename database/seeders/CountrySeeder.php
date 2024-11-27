<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name_ar' => 'السعوديه', 'name_en' => 'Saudi Arabia'],
            ['name_ar' => 'مصر', 'name_en' => 'Egypt'],
        ];

        Country::insert($data);
    }
}
