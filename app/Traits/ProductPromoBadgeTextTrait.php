<?php
namespace App\Traits;

trait ProductPromoBadgeTextTrait{

    public function productPromoBadgeText($manage_stock, $qty, $in_stock, $current_date, $new_to)
    {
        if (($manage_stock==1 && $qty==0) || ($in_stock==0)){
            return '<div class="product-promo-text style1 bg-danger">
                        <span>Stock Out</span>
                    </div>';
        }elseif($current_date <= $new_to) {
            return '<div class="product-promo-text style1">
                        <span>New</span>
                    </div>';
        }else {
            return null;
        }
    }
}
