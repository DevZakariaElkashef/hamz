<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Option>
 */
class OptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $arabicAttributeOptions = [
            'مقاس صغير','مقاس متوسط','مقاس كبير','أحمر','أزرق','أخضر','جلدي','نايلون','خشب','معدن','طويل','قصير','مستدير','مربع','مستقيم','منحني',
        ];

        return [
            'value_ar' => $this->faker->randomElement($arabicAttributeOptions),
            'value_en' => fake()->word(),    
        ];
    }
}
