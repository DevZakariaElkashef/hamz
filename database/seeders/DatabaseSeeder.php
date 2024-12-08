<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            MallRoleSeeder::class,
            BoothRoleSeeder::class,
            EarnRoleSeeder::class,
            CouponRoleSeeder::class,
            UsedMarktRoleSeeder::class,
            RfoofRoleSeeder::class,
            HamzRoleSeeder::class,
            CountrySeeder::class,
            AdvertiserCharactersSeeder::class,
            DirectionSeeder::class,
            ProductStatusSeeder::class,
            CitySeeder::class,
            UserSeeder::class,
            SliderSeeder::class,
            OrderStatusSeeder::class,
            SectionSeeder::class,
            VideoSeeder::class,
            ContactTypeSeeder::class,
            ApplicationSeeder::class,
            AboutSeeder::class,
            TermSeeder::class
        ]);
    }
}
