<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cities = [
            'الرياض', 'جدة', 'مكة', 'المدينة المنورة', 'الدمام',
            'الخبر', 'الطائف', 'بريدة', 'الظهران', 'ينبع',
            'أبها', 'خميس مشيط', 'جيزان', 'نجران', 'حائل'
        ];

        return [
            'name_ar' => $this->faker->randomElement($cities),
            'name_en' => fake()->word()
        ];
    }
}
