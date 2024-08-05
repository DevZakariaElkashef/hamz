<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name_ar' => 'عميل', 'name_en' => 'client'],
            ['name_ar' => 'تاجر', 'name_en' => 'seller'],
            ['name_ar' => 'المدير العام', 'name_en' => 'super-admin'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
