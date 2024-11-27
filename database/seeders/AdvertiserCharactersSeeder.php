<?php

namespace Database\Seeders;

use App\Models\AdvertiserCharacter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdvertiserCharactersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name_ar' => 'مالك', 'name_en' => 'Owner'],
            ['name_ar' => 'وسيط', 'name_en' => 'Mediator'],
        ];

        AdvertiserCharacter::insert($data);
    }
}
