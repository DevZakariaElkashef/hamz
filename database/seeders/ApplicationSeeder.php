<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Application::create([
            'name_ar' => 'المولات',
            'name_en' => 'mall',
            'logo' => 'test.jpg'
        ]);

        Application::create([
            'name_ar' => 'البوثات',
            'name_en' => 'Booth',
            'logo' => 'test.jpg'
        ]);

        Application::create([
            'name_ar' => 'شاهد وإكسب',
            'name_en' => 'Watch_And_Win',
            'logo' => 'test.jpg'
        ]);

        Application::create([
            'name_ar' => 'تطبيق الكوبونات',
            'name_en' => 'coupons_app',
            'logo' => 'test.jpg'
        ]);

        Application::create([
            'name_ar' => 'السوق المستعمل',
            'name_en' => 'Used_Market',
            'logo' => 'test.jpg'
        ]);

        Application::create([
            'name_ar' => 'رفوف',
            'name_en' => 'rfoof',
            'logo' => 'test.jpg'
        ]);
    }
}
