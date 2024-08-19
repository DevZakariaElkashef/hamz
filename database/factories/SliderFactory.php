<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slider>
 */
class SliderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $apps = config('app.apps'); // return array of values
        $arabicSliderWords = [
            'مذهل','مميز','حديث','فخم','ملون','راقي','أنيق','مبتكر','جديد','حصري','رائع','مذهل','مستقبلي','جذاب','ممتع'
        ];

        return [
            'name_ar' => $this->faker->randomElement($arabicSliderWords),
            'name_en' => fake()->word(),
            'image' => str_replace(['public', '\\'], ['', '/'], fake()->image('public/uploads/sliders', 640, 480, 'art4muslim')),
            'url' => fake()->url(),
            'app' => fake()->randomElement($apps)
        ];
    }
}
