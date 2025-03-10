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

            ['name' => 'coupon.coupons.index'],
            ['name' => 'coupon.coupons.create'],
            ['name' => 'coupon.coupons.update'],
            ['name' => 'coupon.coupons.delete'],
            ['name' => 'coupon.coupons.export'],
            ['name' => 'coupon.coupons.import'],

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
