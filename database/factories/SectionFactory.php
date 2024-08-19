<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $arabicMallSections = [
            'الأزياء','الإلكترونيات','المجوهرات','الرياضة','الأثاث','المستلزمات المنزلية','الألعاب','الصحة والجمال','الكتب والمكتبات','الطعام والشراب','الحقائب والأحذية','المستحضرات الطبية','المنتجات الطبيعية','التحف والهدايا','الأدوات المكتبية'
        ];

        return [
            'name_ar' => $this->faker->randomElement($arabicMallSections),
            'name_en' => fake()->word(),
            'image' => str_replace(['public', '\\'], ['', '/'], fake()->image('public/uploads/sections', 640, 480, 'art4muslim')),
            'app' => 'mall'
        ];
    }
}
