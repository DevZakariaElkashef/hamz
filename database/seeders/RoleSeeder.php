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
            ['name' => 'super-admin', 'app' => 'all'],
            ['name' => 'client', 'app' => 'all'],
            ['name' => 'mall-seller', 'app' => 'all'],
            ['name' => 'booth-seller', 'app' => 'all'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate($role);
        }

        // Define stores permissions
        $permissions = [
            ['name' => 'dashboard.index', 'app' => 'mall'],
            ['name' => 'dashboard.index', 'app' => 'booth'],

            ['name' => 'sliders.index', 'app' => 'stores'],
            ['name' => 'sliders.create', 'app' => 'stores'],
            ['name' => 'sliders.update', 'app' => 'stores'],
            ['name' => 'sliders.delete', 'app' => 'stores'],

            ['name' => 'sections.index', 'app' => 'stores'],
            ['name' => 'sections.create', 'app' => 'stores'],
            ['name' => 'sections.update', 'app' => 'stores'],
            ['name' => 'sections.delete', 'app' => 'stores'],
            ['name' => 'sections.export', 'app' => 'stores'],
            ['name' => 'sections.import', 'app' => 'stores'],

            ['name' => 'stores.index', 'app' => 'stores'],
            ['name' => 'stores.create', 'app' => 'stores'],
            ['name' => 'stores.update', 'app' => 'stores'],
            ['name' => 'stores.delete', 'app' => 'stores'],
            ['name' => 'stores.export', 'app' => 'stores'],
            ['name' => 'stores.import', 'app' => 'stores'],

            ['name' => 'coupons.index', 'app' => 'stores'],
            ['name' => 'coupons.create', 'app' => 'stores'],
            ['name' => 'coupons.update', 'app' => 'stores'],
            ['name' => 'coupons.delete', 'app' => 'stores'],
            ['name' => 'coupons.export', 'app' => 'stores'],
            ['name' => 'coupons.import', 'app' => 'stores'],

            ['name' => 'categories.index', 'app' => 'stores'],
            ['name' => 'categories.create', 'app' => 'stores'],
            ['name' => 'categories.update', 'app' => 'stores'],
            ['name' => 'categories.delete', 'app' => 'stores'],
            ['name' => 'categories.export', 'app' => 'stores'],
            ['name' => 'categories.import', 'app' => 'stores'],

            ['name' => 'brands.index', 'app' => 'stores'],
            ['name' => 'brands.create', 'app' => 'stores'],
            ['name' => 'brands.update', 'app' => 'stores'],
            ['name' => 'brands.delete', 'app' => 'stores'],
            ['name' => 'brands.export', 'app' => 'stores'],
            ['name' => 'brands.import', 'app' => 'stores'],

            ['name' => 'attributes.index', 'app' => 'stores'],
            ['name' => 'attributes.create', 'app' => 'stores'],
            ['name' => 'attributes.update', 'app' => 'stores'],
            ['name' => 'attributes.delete', 'app' => 'stores'],
            ['name' => 'attributes.export', 'app' => 'stores'],
            ['name' => 'attributes.import', 'app' => 'stores'],

            ['name' => 'options.index', 'app' => 'stores'],
            ['name' => 'options.create', 'app' => 'stores'],
            ['name' => 'options.update', 'app' => 'stores'],
            ['name' => 'options.delete', 'app' => 'stores'],
            ['name' => 'options.export', 'app' => 'stores'],
            ['name' => 'options.import', 'app' => 'stores'],

            ['name' => 'products.index', 'app' => 'stores'],
            ['name' => 'products.create', 'app' => 'stores'],
            ['name' => 'products.update', 'app' => 'stores'],
            ['name' => 'products.delete', 'app' => 'stores'],
            ['name' => 'products.export', 'app' => 'stores'],
            ['name' => 'products.import', 'app' => 'stores'],

            ['name' => 'orders.index', 'app' => 'stores'],
            ['name' => 'orders.update', 'app' => 'stores'],
            ['name' => 'orders.delete', 'app' => 'stores'],
            ['name' => 'orders.export', 'app' => 'stores'],

            ['name' => 'report.product_sales', 'app' => 'stores'],
            ['name' => 'report.vendor_sales', 'app' => 'stores'],
            ['name' => 'report.order_status', 'app' => 'stores'],
            ['name' => 'report.order_details', 'app' => 'stores'],
            ['name' => 'report.customer_activity', 'app' => 'stores'],
            ['name' => 'report.low_stock_alert', 'app' => 'stores'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }

        // Attach all permissions to the super-admin role
        $superAdminRole = Role::where('name', 'super-admin')->first();
        $allPermissions = Permission::all()->pluck('id')->toArray();
        $superAdminRole->permissions()->sync($allPermissions);

        // Attach all permissions to the mall-seller role
        $mallPermissions = Permission::stores()->get();
        $mallSellerRole = Role::where('name', 'mall-seller')->first();
        $mallSellerRole->permissions()->sync($mallPermissions);

    }
}
