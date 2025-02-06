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

            ['name' => 'mall.sections.index'],
            ['name' => 'mall.sections.create'],
            ['name' => 'mall.sections.update'],
            ['name' => 'mall.sections.delete'],
            ['name' => 'mall.sections.export'],
            ['name' => 'mall.sections.import'],

            ['name' => 'mall.stores.index'],
            ['name' => 'mall.stores.create'],
            ['name' => 'mall.stores.update'],
            ['name' => 'mall.stores.delete'],
            ['name' => 'mall.stores.export'],
            ['name' => 'mall.stores.import'],


            ['name' => 'booth.sections.index'],
            ['name' => 'booth.sections.create'],
            ['name' => 'booth.sections.update'],
            ['name' => 'booth.sections.delete'],
            ['name' => 'booth.sections.export'],
            ['name' => 'booth.sections.import'],


            ['name' => 'booth.stores.index'],
            ['name' => 'booth.stores.create'],
            ['name' => 'booth.stores.update'],
            ['name' => 'booth.stores.delete'],
            ['name' => 'booth.stores.export'],
            ['name' => 'booth.stores.import'],

            ['name' => 'earn.sliders.index'],
            ['name' => 'earn.sliders.create'],
            ['name' => 'earn.sliders.update'],
            ['name' => 'earn.sliders.delete'],

            ['name' => 'earn.packages.index'],
            ['name' => 'earn.packages.create'],
            ['name' => 'earn.packages.update'],
            ['name' => 'earn.packages.delete'],

            ['name' => 'earn.categories.index'],
            ['name' => 'earn.categories.create'],
            ['name' => 'earn.categories.update'],
            ['name' => 'earn.categories.delete'],
            ['name' => 'earn.categories.export'],
            ['name' => 'earn.categories.import'],

            ['name' => 'coupon.packages.index'],
            ['name' => 'coupon.packages.create'],
            ['name' => 'coupon.packages.update'],
            ['name' => 'coupon.packages.delete'],

            ['name' => 'coupon.sliders.index'],
            ['name' => 'coupon.sliders.create'],
            ['name' => 'coupon.sliders.update'],
            ['name' => 'coupon.sliders.delete'],

            ['name' => 'coupon.categories.index'],
            ['name' => 'coupon.categories.create'],
            ['name' => 'coupon.categories.update'],
            ['name' => 'coupon.categories.delete'],
            ['name' => 'coupon.categories.export'],
            ['name' => 'coupon.categories.import'],


            ['name' => 'hamz.sliders.index'],
            ['name' => 'hamz.sliders.create'],
            ['name' => 'hamz.sliders.update'],
            ['name' => 'hamz.sliders.delete'],




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
            ['name' => 'hamz.applications.create'],
            ['name' => 'hamz.applications.update'],
            ['name' => 'hamz.applications.delete'],

            ['name' => 'hamz.withdrows.index']

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
