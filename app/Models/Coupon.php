<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Coupon extends Model
{
    protected $fillable = [
        'slug', 'coupon_code', 'value', 'discount_type', 'free_shipping', 'minimum_spend', 'maximum_spend', 'usage_limit_per_coupon',
        'usage_limit_per_customer', 'used', 'is_active', 'start_date', 'end_date',
    ];

    //old
    public function couponTranslations()
    {
    	return $this->hasMany(CouponTranslation::class,'coupon_id');
    }


    //new
    public function couponTranslation()
    {
        $locale = Session::get('currentLocal');
    	return $this->hasOne(CouponTranslation::class,'coupon_id')
                    ->where('locale',$locale);

    }

    public function couponTranslationEnglish()
    {
    	return $this->hasOne(CouponTranslation::class,'coupon_id')
                    ->where('locale','en');
    }


    public function products()
    {
        return $this->belongsToMany(Product::class, 'coupon_products');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'coupon_categories');
    }

    public function orders()
    {
        return $this->hasMany(Order::class,'coupon_id');
    }
}
