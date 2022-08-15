<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class=PermissionSeeder

        DB::table('permissions')->delete();

        $permissions = array(
            array(
				'id' => 1,
				'guard_name' => 'web',
				'name' => 'product'
			),
            array(
				'id' => 2,
				'guard_name' => 'web',
				'name' => 'catalog'
			),
            array(
				'id' => 3,
				'guard_name' => 'web',
				'name' => 'product-view'
			),
            array(
				'id' => 4,
				'guard_name' => 'web',
				'name' => 'product-store'
			),
            array(
				'id' => 5,
				'guard_name' => 'web',
				'name' => 'product-edit'
			),
            array(
				'id' => 6,
				'guard_name' => 'web',
				'name' => 'product-action'
			),
            array(
				'id' => 7,
				'guard_name' => 'web',
				'name' => 'category'
			),
            array(
				'id' => 8,
				'guard_name' => 'web',
				'name' => 'category-view'
			),
            array(
				'id' => 9,
				'guard_name' => 'web',
				'name' => 'category-store'
			),
            array(
				'id' => 10,
				'guard_name' => 'web',
				'name' => 'category-edit'
			),
            array(
				'id' => 11,
				'guard_name' => 'web',
				'name' => 'category-action'
			),
            array(
				'id' => 12,
				'guard_name' => 'web',
				'name' => 'brand'
			),
            array(
				'id' => 13,
				'guard_name' => 'web',
				'name' => 'brand-view'
			),
            array(
				'id' => 14,
				'guard_name' => 'web',
				'name' => 'brand-store'
			),
            array(
				'id' => 15,
				'guard_name' => 'web',
				'name' => 'brand-edit'
			),
            array(
				'id' => 16,
				'guard_name' => 'web',
				'name' => 'brand-action'
			),
            array(
				'id' => 17,
				'guard_name' => 'web',
				'name' => 'attribute_set'
			),
            array(
				'id' => 18,
				'guard_name' => 'web',
				'name' => 'attribute_set-view'
			),
            array(
				'id' => 19,
				'guard_name' => 'web',
				'name' => 'attribute_set-store'
			),
            array(
				'id' => 20,
				'guard_name' => 'web',
				'name' => 'attribute_set-edit'
			),
            array(
				'id' => 21,
				'guard_name' => 'web',
				'name' => 'attribute_set-action'
			),
            array(
				'id' => 22,
				'guard_name' => 'web',
				'name' => 'attribute'
			),
            array(
				'id' => 23,
				'guard_name' => 'web',
				'name' => 'attribute-view'
			),
            array(
				'id' => 24,
				'guard_name' => 'web',
				'name' => 'attribute-store'
			),
            array(
				'id' => 25,
				'guard_name' => 'web',
				'name' => 'attribute-edit'
			),
            array(
				'id' => 26,
				'guard_name' => 'web',
				'name' => 'attribute-action'
			),
            array(
				'id' => 27,
				'guard_name' => 'web',
				'name' => 'tag'
			),
            array(
				'id' => 28,
				'guard_name' => 'web',
				'name' => 'tag-view'
			),
            array(
				'id' => 29,
				'guard_name' => 'web',
				'name' => 'tag-store'
			),
            array(
				'id' => 30,
				'guard_name' => 'web',
				'name' => 'tag-edit'
			),
            array(
				'id' => 31,
				'guard_name' => 'web',
				'name' => 'tag-action'
			),
            array(
				'id' => 32,
				'guard_name' => 'web',
				'name' => 'flash_sale'
			),
            array(
				'id' => 33,
				'guard_name' => 'web',
				'name' => 'flash_sale-view'
			),
            array(
				'id' => 34,
				'guard_name' => 'web',
				'name' => 'flash_sale-store'
			),
            array(
				'id' => 35,
				'guard_name' => 'web',
				'name' => 'flash_sale-edit'
			),
            array(
				'id' => 36,
				'guard_name' => 'web',
				'name' => 'flash_sale-action'
			),
            array(
				'id' => 37,
				'guard_name' => 'web',
				'name' => 'coupon'
			),
            array(
				'id' => 38,
				'guard_name' => 'web',
				'name' => 'coupon-view'
			),
            array(
				'id' => 39,
				'guard_name' => 'web',
				'name' => 'coupon-store'
			),
            array(
				'id' => 40,
				'guard_name' => 'web',
				'name' => 'coupon-edit'
			),
            array(
				'id' => 41,
				'guard_name' => 'web',
				'name' => 'coupon-action'
			),
            array(
				'id' => 42,
				'guard_name' => 'web',
				'name' => 'page'
			),
            array(
				'id' => 43,
				'guard_name' => 'web',
				'name' => 'page-view'
			),
            array(
				'id' => 44,
				'guard_name' => 'web',
				'name' => 'page-store'
			),
            array(
				'id' => 45,
				'guard_name' => 'web',
				'name' => 'page-edit'
			),
            array(
				'id' => 46,
				'guard_name' => 'web',
				'name' => 'page-action'
			),
            array(
				'id' => 47,
				'guard_name' => 'web',
				'name' => 'menu'
			),
            array(
				'id' => 48,
				'guard_name' => 'web',
				'name' => 'menu-view'
			),
            array(
				'id' => 49,
				'guard_name' => 'web',
				'name' => 'menu-store'
			),
            array(
				'id' => 50,
				'guard_name' => 'web',
				'name' => 'menu-edit'
			),
            array(
				'id' => 51,
				'guard_name' => 'web',
				'name' => 'menu-action'
			),
            array(
				'id' => 52,
				'guard_name' => 'web',
				'name' => 'menu_item'
			),
            array(
				'id' => 53,
				'guard_name' => 'web',
				'name' => 'menu_item-view'
			),
            array(
				'id' => 54,
				'guard_name' => 'web',
				'name' => 'menu_item-store'
			),
            array(
				'id' => 55,
				'guard_name' => 'web',
				'name' => 'menu_item-edit'
			),
            array(
				'id' => 56,
				'guard_name' => 'web',
				'name' => 'menu_item-action'
			),
            array(
				'id' => 57,
				'guard_name' => 'web',
				'name' => 'role'
			),
            array(
				'id' => 58,
				'guard_name' => 'web',
				'name' => 'role-view'
			),
            array(
				'id' => 59,
				'guard_name' => 'web',
				'name' => 'role-store'
			),
            array(
				'id' => 60,
				'guard_name' => 'web',
				'name' => 'role-edit'
			),
            array(
				'id' => 61,
				'guard_name' => 'web',
				'name' => 'role-action'
			),
            array(
				'id' => 62,
				'guard_name' => 'web',
				'name' => 'set_permission'
			),
            array(
				'id' => 63,
				'guard_name' => 'web',
				'name' => 'user'
			),
            array(
				'id' => 64,
				'guard_name' => 'web',
				'name' => 'user-view'
			),
            array(
				'id' => 65,
				'guard_name' => 'web',
				'name' => 'user-store'
			),
            array(
				'id' => 66,
				'guard_name' => 'web',
				'name' => 'user-edit'
			),
            array(
				'id' => 67,
				'guard_name' => 'web',
				'name' => 'user-action'
			),
            array(
				'id' => 68,
				'guard_name' => 'web',
				'name' => 'appearance'
			),
            array(
				'id' => 69,
				'guard_name' => 'web',
				'name' => 'store_front'
			),
            array(
				'id' => 70,
				'guard_name' => 'web',
				'name' => 'slider'
			),
            array(
				'id' => 71,
				'guard_name' => 'web',
				'name' => 'slider-view'
			),
            array(
				'id' => 72,
				'guard_name' => 'web',
				'name' => 'slider-store'
			),
            array(
				'id' => 73,
				'guard_name' => 'web',
				'name' => 'slider-edit'
			),
            array(
				'id' => 74,
				'guard_name' => 'web',
				'name' => 'slider-action'
			),
            array(
				'id' => 75,
				'guard_name' => 'web',
				'name' => 'site-setting'
			),
            array(
				'id' => 76,
				'guard_name' => 'web',
				'name' => 'setting'
			),
            array(
				'id' => 77,
				'guard_name' => 'web',
				'name' => 'locale'
			),
            array(
				'id' => 78,
				'guard_name' => 'web',
				'name' => 'locale-view'
			),
            array(
				'id' => 79,
				'guard_name' => 'web',
				'name' => 'locale-store'
			),
            array(
				'id' => 80,
				'guard_name' => 'web',
				'name' => 'locale-edit'
			),
            array(
				'id' => 81,
				'guard_name' => 'web',
				'name' => 'locale-action'
			),
            array(
				'id' => 82,
				'guard_name' => 'web',
				'name' => 'users_and_roles'
			),
            array(
				'id' => 83,
				'guard_name' => 'web',
				'name' => 'country'
			),
            array(
				'id' => 84,
				'guard_name' => 'web',
				'name' => 'country-view'
			),
            array(
				'id' => 85,
				'guard_name' => 'web',
				'name' => 'country-store'
			),
            array(
				'id' => 86,
				'guard_name' => 'web',
				'name' => 'country-edit'
			),
            array(
				'id' => 87,
				'guard_name' => 'web',
				'name' => 'country-action'
			),
            array(
				'id' => 88,
				'guard_name' => 'web',
				'name' => 'currency'
			),
            array(
				'id' => 89,
				'guard_name' => 'web',
				'name' => 'currency-view'
			),
            array(
				'id' => 90,
				'guard_name' => 'web',
				'name' => 'currency-store'
			),
            array(
				'id' => 91,
				'guard_name' => 'web',
				'name' => 'currency-edit'
			),
            array(
				'id' => 92,
				'guard_name' => 'web',
				'name' => 'currency-action'
			),
        );

        DB::table('permissions')->insert($permissions);
    }
}
