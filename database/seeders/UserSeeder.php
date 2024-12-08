<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'super admin',
            'email' => "z@z.com",
            'role_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'test',
            'phone' => "0500000000",
            'role_id' => 2,
        ]);

        User::factory()->create([
            'name' => 'seller',
            'email' => "s@s.com",
            'role_id' => 3,
        ]);

        User::factory(100)->create();
    }
}
