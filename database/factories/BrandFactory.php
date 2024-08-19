<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $arabicCategories = [
            'الماس','أنيق','تطور','مجموعة الرائد','النجاح','الروح','الأصالة','الفخامة','العالم','الأفضل',
        ];

        return [
            'name_ar' => $this->faker->randomElement($arabicCategories),
            'name_en' => fake()->word(),
            'image' => str_replace(['public', '\\'], ['', '/'], fake()->image('public/uploads/brands', 640, 480, 'art4muslim')),

        ];
    }
}
