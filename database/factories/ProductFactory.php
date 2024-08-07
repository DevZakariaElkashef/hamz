<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
            'image' => str_replace(['public', '\\'], ['', '/'], fake()->image('public/uploads/products', 640, 480, 'art4muslim')),
            'price' => fake()->numberBetween(111, 9999),
            'offer' => fake()->numberBetween(111, 9999),
            'start_offer_date' => fake()->date(),
            'end_offer_date' => fake()->date(),
            'qty' => fake()->numberBetween(11111, 99999),
            'app' => fake()->randomElement($apps)
        ];
    }
}
