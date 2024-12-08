<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class MallRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define stores permissions
        $permissions = [
            ['name' => 'mall.dashboard.index'],

            ['name' => 'mall.sliders.index'],
            ['name' => 'mall.sliders.create'],
            ['name' => 'mall.sliders.update'],
            ['name' => 'mall.sliders.delete'],

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

            ['name' => 'mall.coupons.index'],
            ['name' => 'mall.coupons.create'],
            ['name' => 'mall.coupons.update'],
            ['name' => 'mall.coupons.delete'],
            ['name' => 'mall.coupons.export'],
            ['name' => 'mall.coupons.import'],

            ['name' => 'mall.categories.index'],
            ['name' => 'mall.categories.create'],
            ['name' => 'mall.categories.update'],
            ['name' => 'mall.categories.delete'],
            ['name' => 'mall.categories.export'],
            ['name' => 'mall.categories.import'],

            ['name' => 'mall.brands.index'],
            ['name' => 'mall.brands.create'],
            ['name' => 'mall.brands.update'],
            ['name' => 'mall.brands.delete'],
            ['name' => 'mall.brands.export'],
            ['name' => 'mall.brands.import'],

            ['name' => 'mall.attributes.index'],
            ['name' => 'mall.attributes.create'],
            ['name' => 'mall.attributes.update'],
            ['name' => 'mall.attributes.delete'],
            ['name' => 'mall.attributes.export'],
            ['name' => 'mall.attributes.import'],

            ['name' => 'mall.options.index'],
            ['name' => 'mall.options.create'],
            ['name' => 'mall.options.update'],
            ['name' => 'mall.options.delete'],
            ['name' => 'mall.options.export'],
            ['name' => 'mall.options.import'],

            ['name' => 'mall.products.index'],
            ['name' => 'mall.products.create'],
            ['name' => 'mall.products.update'],
            ['name' => 'mall.products.delete'],
            ['name' => 'mall.products.export'],
            ['name' => 'mall.products.import'],

            ['name' => 'mall.orders.index'],
            ['name' => 'mall.orders.update'],
            ['name' => 'mall.orders.delete'],
            ['name' => 'mall.orders.export'],

            ['name' => 'mall.report.product_sales'],
            ['name' => 'mall.report.vendor_sales'],
            ['name' => 'mall.report.order_status'],
            ['name' => 'mall.report.order_details'],
            ['name' => 'mall.report.customer_activity'],
            ['name' => 'mall.report.low_stock_alert'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }

        // Attach all permissions to the super-admin role
        $superAdminRole = Role::where('name', 'super-admin')->first();
        $allPermissions = Permission::all()->pluck('id')->toArray();
        $superAdminRole->permissions()->sync($allPermissions);

        // Attach all permissions to the mall-seller role
        $storePermissions = Permission::get();
        $storeSellerRole = Role::where('name', 'seller')->first();
        $storeSellerRole->permissions()->sync($storePermissions);
    }
}
