<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $apps = config('app.apps'); // return array of values
        return [
            'name_ar' => fake()->word(),
            'name_en' => fake()->word(),
            'image' => str_replace(['public', '\\'], ['', '/'], fake()->image('public/uploads/categories', 640, 480, 'art4muslim')),
            'app' => fake()->randomElement($apps)
        ];
    }
}
