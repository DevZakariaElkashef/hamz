<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RfoofRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define stores permissions
        $permissions = [
            ['name' => 'rfoof.dashboard.index'],

            ['name' => 'rfoof.categories.index'],
            ['name' => 'rfoof.categories.create'],
            ['name' => 'rfoof.categories.update'],
            ['name' => 'rfoof.categories.delete'],

            ['name' => 'rfoof.subCategories.index'],
            ['name' => 'rfoof.subCategories.create'],
            ['name' => 'rfoof.subCategories.update'],
            ['name' => 'rfoof.subCategories.delete'],

            ['name' => 'rfoof.products.index'],

            ['name' => 'rfoof.comments.index'],

            ['name' => 'rfoof.complains.index'],

            ['name' => 'rfoof.favourites.index'],

            ['name' => 'rfoof.notifications.index'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }

        // Attach all permissions to the super-admin role
        $superAdminRole = Role::where('name', 'super-admin')->first();
        $allPermissions = Permission::all()->pluck('id')->toArray();
        $superAdminRole->permissions()->sync($allPermissions);
    }
}
