<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AttributeOption>
 */
class AttributeOptionFactory extends Factory
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
            'name_ar' => $this->faker->randomElement($arabicAttributeOptions),
            'name_en' => fake()->word(),
            'additional_price' => rand(0, 100),
            'is_required' => fake()->boolean()
        ];
    }
}
