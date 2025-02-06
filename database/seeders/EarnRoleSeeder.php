<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class EarnRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define stores permissions
        $permissions = [
            ['name' => 'earn.dashboard.index'],

            ['name' => 'earn.views.index'],

            ['name' => 'earn.videos.index'],
            ['name' => 'earn.videos.create'],
            ['name' => 'earn.videos.update'],
            ['name' => 'earn.videos.delete'],

            ['name' => 'earn.subscriptions.index'],

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }

        // Attach all permissions to the super-admin role
        $superAdminRole = Role::where('name', 'super-admin')->first();
        $allPermissions = Permission::all()->pluck('id')->toArray();
        $superAdminRole->permissions()->sync($allPermissions);

        // Attach all permissions to the earn-seller role
        $storePermissions = Permission::get();
        $storeSellerRole = Role::where('name', 'seller')->first();
        $storeSellerRole->permissions()->sync($storePermissions);
    }
}
