<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Store;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\Attribute;
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
                                    ->has(Brand::factory(2)) // Assuming each Product has a Brand
                            )
                    )
            )
            ->create();
    }
}
