<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_ar' => fake()->sentence(),
            'title_en' => fake()->sentence(),
            'path' => str_replace(['public', '\\'], ['', '/'], 'public/uploads/videos/' . fake()->uuid() . '.mp4'),
            'seller_id' => rand(1, 10),
            'category_id' => Category::factory(),
            'reward_amount' => rand(10, 100)
        ];
    }
}
