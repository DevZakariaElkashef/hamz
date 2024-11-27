<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsedMarktRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define stores permissions
        $permissions = [
            ['name' => 'usedmarket.dashboard.index'],

            ['name' => 'usedmarket.categories.index'],
            ['name' => 'usedmarket.categories.create'],
            ['name' => 'usedmarket.categories.update'],
            ['name' => 'usedmarket.categories.delete'],

            ['name' => 'usedmarket.subCategories.index'],
            ['name' => 'usedmarket.subCategories.create'],
            ['name' => 'usedmarket.subCategories.update'],
            ['name' => 'usedmarket.subCategories.delete'],

            ['name' => 'usedmarket.products.index'],

            ['name' => 'usedmarket.comments.index'],

            ['name' => 'usedmarket.complains.index'],

            ['name' => 'usedmarket.favourites.index'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }

        // Attach all permissions to the super-admin role
        $superAdminRole = Role::where('name', 'super-admin')->first();
        $allPermissions = Permission::all()->pluck('id')->toArray();
        $superAdminRole->permissions()->sync($allPermissions);

        // Attach all permissions to the usedmarket-seller role
        $storePermissions = Permission::get();
        $storeSellerRole = Role::where('name', 'seller')->first();
        $storeSellerRole->permissions()->sync($storePermissions);
    }
}
