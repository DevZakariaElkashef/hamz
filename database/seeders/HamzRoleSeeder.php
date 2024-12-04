<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HamzRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define stores permissions
        $permissions = [
            ['name' => 'hamz.users.index'],
            ['name' => 'hamz.users.create'],
            ['name' => 'hamz.users.update'],
            ['name' => 'hamz.users.delete'],

            ['name' => 'hamz.vendors.index'],
            ['name' => 'hamz.vendors.create'],
            ['name' => 'hamz.vendors.update'],
            ['name' => 'hamz.vendors.delete'],

            ['name' => 'hamz.employees.index'],
            ['name' => 'hamz.employees.create'],
            ['name' => 'hamz.employees.update'],
            ['name' => 'hamz.employees.delete'],

            ['name' => 'hamz.roles.index'],
            ['name' => 'hamz.roles.create'],
            ['name' => 'hamz.roles.update'],
            ['name' => 'hamz.roles.delete'],

            ['name' => 'hamz.contactTypes.index'],
            ['name' => 'hamz.contactTypes.create'],
            ['name' => 'hamz.contactTypes.update'],
            ['name' => 'hamz.contactTypes.delete'],

            ['name' => 'hamz.cities.index'],
            ['name' => 'hamz.cities.create'],
            ['name' => 'hamz.cities.update'],
            ['name' => 'hamz.cities.delete'],
            ['name' => 'hamz.cities.export'],
            ['name' => 'hamz.cities.import'],

            ['name' => 'hamz.contacts.index'],
            ['name' => 'hamz.contacts.create'],
            ['name' => 'hamz.contacts.update'],
            ['name' => 'hamz.contacts.delete'],

            ['name' => 'hamz.socials.index'],
            ['name' => 'hamz.socials.create'],
            ['name' => 'hamz.socials.update'],
            ['name' => 'hamz.socials.delete'],

            ['name' => 'hamz.applications.index'],
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
