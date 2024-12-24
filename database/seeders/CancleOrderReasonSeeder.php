<?php

namespace Database\Seeders;

use App\Models\CancleOrderReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CancleOrderReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CancleOrderReason::create([
            'name_ar' => 'مزاجى',
            'name_en' => 'reason 1'
        ]);

        CancleOrderReason::create([
            'name_ar' => 'انا حر',
            'name_en' => 'reason 2'
        ]);

        CancleOrderReason::create([
            'name_ar' => 'معلش',
            'name_en' => 'reason 3'
        ]);

        CancleOrderReason::create([
            'name_ar' => 'اخرى',
            'name_en' => 'reason 4'
        ]);
    }
}
