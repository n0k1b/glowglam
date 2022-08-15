<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponTranslation extends Model
{
    protected $fillable = ['coupon_id','locale','coupon_name'];
}
