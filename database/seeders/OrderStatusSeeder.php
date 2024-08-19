<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // OrderStatus::factory(4)->create();
        OrderStatus::create([
            'name_ar' => 'قيد الإنتظار',
            'name_en' => 'Painding',
        ]);

        OrderStatus::create([
            'name_ar' => 'قيد التجهيز',
            'name_en' => 'Preparing',
        ]);

        OrderStatus::create([
            'name_ar' => 'قيد الشحن',
            'name_en' => 'Under shipment',
        ]);

        OrderStatus::create([
            'name_ar' => 'منتهى',
            'name_en' => 'Finished',
        ]);

        OrderStatus::create([
            'name_ar' => 'ملغى',
            'name_en' => 'Canceled',
        ]);
    }
}
