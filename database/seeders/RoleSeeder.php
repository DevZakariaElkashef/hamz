<?php

namespace Database\Seeders;

use App\Models\Permission;
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
        // Define roles
        $roles = [
            ['name_ar' => 'المدير العام', 'name_en' => 'super-admin', 'app' => 'all'],
            ['name_ar' => 'عميل', 'name_en' => 'client', 'app' => 'all'],
            ['name_ar' => 'تاجر', 'name_en' => 'seller', 'app' => 'all'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate($role);
        }

        // Define permissions
        $permissions = [
            ['name' => 'create-users'],
            ['name' => 'update-users'],
            ['name' => 'view-users'],
            ['name' => 'destroy-users'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }

        // Attach all permissions to the super-admin role
        $superAdminRole = Role::where('name_en', 'super-admin')->first();
        $allPermissions = Permission::all()->pluck('id')->toArray();

        $superAdminRole->permissions()->sync($allPermissions);
    }
}
