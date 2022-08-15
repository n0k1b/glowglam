<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class OrderDetail extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function productTranslation()
    {
    	$locale = Session::get('currentLocal');
    	return $this->hasOne(ProductTranslation::class,'product_id','product_id')
                ->where('local',$locale);
    }

    

    //Admin Dashboard
    public function orderProductTranslation()
    {
    	$locale = Session::get('currentLocal');
    	return $this->hasOne(ProductTranslation::class,'product_id','product_id')
                ->where('local',$locale);
    }

    //Admin Dashboard
    public function orderProductTranslationEnglish()
    {
    	return $this->hasOne(ProductTranslation::class,'product_id','product_id')
                        ->where('local','en');
    }


    public function baseImage()
    {
        return $this->hasOne(ProductImage::class,'product_id','product_id')
                    ->where('type','base');
    }
}

