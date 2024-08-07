<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
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
            'description_ar' => fake()->sentence(),
            'description_en' => fake()->sentence(),
            'image' => str_replace(['public', '\\'], ['', '/'], fake()->image('public/uploads/stores', 640, 480, 'art4muslim')),
            'lat' => fake()->latitude(),
            'lng' => fake()->longitude(),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'app' => fake()->randomElement($apps)
        ];
    }
}
