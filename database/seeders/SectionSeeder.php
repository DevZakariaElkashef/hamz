<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Store;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\Attribute;
use App\Models\Option;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::factory(2)
            ->has(
                Store::factory(2)
                    ->has(
                        Category::factory(2)
                            ->has(
                                Product::factory(2)
                                    ->for(Brand::factory(), 'brand')
                                    ->afterCreating(function (Product $product) {
                                        $attributes = Attribute::factory(3)
                                            ->has(Option::factory(3))
                                            ->create();

                                        foreach ($attributes as $attribute) {
                                            $option = $attribute->options->random();
                                            $product->attributes()->attach($attribute->id, [
                                                'option_id' => $option->id,
                                                'is_required' => rand(0, 1),
                                                'additional_price' => rand(0, 100),
                                            ]);
                                        }
                                    })
                            )
                    )
                    ->has(Brand::factory(2))
            )
            ->create();


            // create section for the dummy vendor account
            Store::factory()->create([
                'user_id' => 3
            ]);
    }
}
