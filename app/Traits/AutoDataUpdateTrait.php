<?php
namespace App\Traits;

use App\Models\FlashSale;
use App\Models\FlashSaleProduct;
use Illuminate\Support\Facades\DB;

trait AutoDataUpdateTrait{

    public function autoDataUpdate()
    {
        // Flash Sale Part

        $flashSales = FlashSale::get();
        if ($flashSales) {
            $flash_sale_products = FlashSaleProduct::whereIn('flash_sale_id',$flashSales->pluck('id'))->get();

            foreach ($flash_sale_products as $value) {
                if (date('Y-m-d') > $value->end_date) {
                    DB::table('flash_sale_products')
                        ->where('product_id',$value->product_id)
                        ->update(['price' => 0, 'qty'=>0]);

                    DB::table('products')
                        ->where('id',$value->product_id)
                        ->update(['special_price' => 0]);
                }
            }
        }
    }

}
