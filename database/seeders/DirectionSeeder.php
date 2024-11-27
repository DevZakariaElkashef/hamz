<?php

namespace Database\Seeders;

use App\Models\Direction;
use Illuminate\Database\Seeder;

class DirectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name_ar' => 'شمال', 'name_en' => 'North'],
            ['name_ar' => 'جنوب', 'name_en' => 'South'],
            ['name_ar' => 'شرق', 'name_en' => 'East'],
            ['name_ar' => 'غرب', 'name_en' => 'West'],
            ['name_ar' => 'شمال شرق', 'name_en' => 'Northeast'],
            ['name_ar' => 'جنوب شرق', 'name_en' => 'Southeast'],
            ['name_ar' => 'شمال غرب', 'name_en' => 'Northwest'],
            ['name_ar' => 'جنوب غرب', 'name_en' => 'Southwest'],
        ];

        Direction::insert($data);
    }
}
