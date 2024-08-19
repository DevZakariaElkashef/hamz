<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductAttribute>
 */
class ProductAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $arabicAttributes = [
            'مقاس','لون','مواد','شكل','طول','عرض','ارتفاع','وزن','حجم','قوة','سرعة','نوع','نمط','تصميم','سماكة',
        ];

        return [
            'name_ar' => $this->faker->randomElement($arabicAttributes),
            'name_en' => fake()->word(),
        ];
    }
}
