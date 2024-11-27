<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class CouponRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define stores permissions
        $permissions = [
            ['name' => 'coupon.dashboard.index'],

            ['name' => 'coupon.sliders.index'],
            ['name' => 'coupon.sliders.create'],
            ['name' => 'coupon.sliders.update'],
            ['name' => 'coupon.sliders.delete'],

            ['name' => 'coupon.coupons.index'],
            ['name' => 'coupon.coupons.create'],
            ['name' => 'coupon.coupons.update'],
            ['name' => 'coupon.coupons.delete'],
            ['name' => 'coupon.coupons.export'],
            ['name' => 'coupon.coupons.import'],

            ['name' => 'coupon.categories.index'],
            ['name' => 'coupon.categories.create'],
            ['name' => 'coupon.categories.update'],
            ['name' => 'coupon.categories.delete'],
            ['name' => 'coupon.categories.export'],
            ['name' => 'coupon.categories.import'],

            ['name' => 'coupon.packages.index'],
            ['name' => 'coupon.packages.create'],
            ['name' => 'coupon.packages.update'],
            ['name' => 'coupon.packages.delete'],


            ['name' => 'coupon.subscriptions.index'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }

        // Attach all permissions to the super-admin role
        $superAdminRole = Role::where('name', 'super-admin')->first();
        $allPermissions = Permission::all()->pluck('id')->toArray();
        $superAdminRole->permissions()->sync($allPermissions);

        // Attach all permissions to the coupon-seller role
        $storePermissions = Permission::get();
        $storeSellerRole = Role::where('name', 'seller')->first();
        $storeSellerRole->permissions()->sync($storePermissions);
    }
}
