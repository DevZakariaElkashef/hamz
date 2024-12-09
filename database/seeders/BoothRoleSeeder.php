<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class BoothRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define stores permissions
        $permissions = [
            ['name' => 'booth.dashboard.index'],

            ['name' => 'booth.sliders.index'],
            ['name' => 'booth.sliders.create'],
            ['name' => 'booth.sliders.update'],
            ['name' => 'booth.sliders.delete'],

            ['name' => 'booth.stores.update'],

            ['name' => 'booth.coupons.index'],
            ['name' => 'booth.coupons.create'],
            ['name' => 'booth.coupons.update'],
            ['name' => 'booth.coupons.delete'],
            ['name' => 'booth.coupons.export'],
            ['name' => 'booth.coupons.import'],

            ['name' => 'booth.categories.index'],
            ['name' => 'booth.categories.create'],
            ['name' => 'booth.categories.update'],
            ['name' => 'booth.categories.delete'],
            ['name' => 'booth.categories.export'],
            ['name' => 'booth.categories.import'],

            ['name' => 'booth.brands.index'],
            ['name' => 'booth.brands.create'],
            ['name' => 'booth.brands.update'],
            ['name' => 'booth.brands.delete'],
            ['name' => 'booth.brands.export'],
            ['name' => 'booth.brands.import'],

            ['name' => 'booth.attributes.index'],
            ['name' => 'booth.attributes.create'],
            ['name' => 'booth.attributes.update'],
            ['name' => 'booth.attributes.delete'],
            ['name' => 'booth.attributes.export'],
            ['name' => 'booth.attributes.import'],

            ['name' => 'booth.options.index'],
            ['name' => 'booth.options.create'],
            ['name' => 'booth.options.update'],
            ['name' => 'booth.options.delete'],
            ['name' => 'booth.options.export'],
            ['name' => 'booth.options.import'],

            ['name' => 'booth.products.index'],
            ['name' => 'booth.products.create'],
            ['name' => 'booth.products.update'],
            ['name' => 'booth.products.delete'],
            ['name' => 'booth.products.export'],
            ['name' => 'booth.products.import'],

            ['name' => 'booth.orders.index'],
            ['name' => 'booth.orders.update'],
            ['name' => 'booth.orders.delete'],
            ['name' => 'booth.orders.export'],

            ['name' => 'booth.report.product_sales'],
            ['name' => 'booth.report.vendor_sales'],
            ['name' => 'booth.report.order_status'],
            ['name' => 'booth.report.order_details'],
            ['name' => 'booth.report.customer_activity'],
            ['name' => 'booth.report.low_stock_alert'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }

        // Attach all permissions to the super-admin role
        $superAdminRole = Role::where('name', 'super-admin')->first();
        $allPermissions = Permission::all()->pluck('id')->toArray();
        $superAdminRole->permissions()->sync($allPermissions);

        // Attach all permissions to the booth-seller role
        $storePermissions = Permission::get();
        $storeSellerRole = Role::where('name', 'seller')->first();
        $storeSellerRole->permissions()->sync($storePermissions);
    }
}
