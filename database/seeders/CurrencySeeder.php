<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan make:seeder CurrencySeeder
        //php artisan db:seed --class=CurrencySeeder
        //https://shopify.dev/api/storefront/reference/common-objects/currencycode#values


        DB::table('currencies')->delete();

        $currencies = array(
			array(
				'id' => 1,
				'currency_name' => 'United Arab Emirates Dirham',
				'currency_code' => 'AED',
			),
			array(
				'id' => 2,
				'currency_name' => 'Afghan Afghani',
				'currency_code' => 'AFN',
			),
			array(
				'id' => 3,
				'currency_name' => 'Albanian Lek',
				'currency_code' => 'ALL',
			),
            array(
				'id' => 4,
				'currency_name' => 'Bangladesh Taka',
				'currency_code' => 'BDT',
			),
            array(
				'id' => 5,
				'currency_name' => 'Indian Rupee',
				'currency_code' => 'INR',
			),
			array(
				'id' => 6,
				'currency_name' => 'United States Dollar',
				'currency_code' => 'USD',
			),
			array(
				'id' => 6,
				'currency_name' => 'United States Dollar',
				'currency_code' => 'USD',
			),

        );

        DB::table('currencies')->insert($currencies);
    }
}
