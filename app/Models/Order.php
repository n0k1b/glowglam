<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'billing_first_name',
        'billing_last_name',
        'billing_email',
        'billing_phone',
        'billing_country',
        'billing_address_1',
        'billing_address_2',
        'billing_city',
        'billing_state',
        'billing_zip_code',
        'shipping_method',
        'shipping_cost',
        'payment_method',
        'coupon_id',
        'payment_id',
        'discount ',
        'total',
        'currency_base_total',
        'currency_symbol',
        'order_status',
        'payment_status',
        'date',
        'tax_id ',
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function shippingDetails()
    {
        return $this->hasOne(Shipping::class);
    }
}
