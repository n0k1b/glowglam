<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\SoftDeletes;


class CategoryProduct extends Model
{
    use SoftDeletes;
    protected $table = 'category_product';


    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function categoryTranslation()
    {
    	$locale = Session::get('currentLocal');
    	return $this->hasOne(CategoryTranslation::class,'category_id','category_id')
                ->where('local',$locale);
    }

    public function categoryTranslationDefaultEnglish()
    {
    	return $this->hasOne(CategoryTranslation::class,'category_id','category_id')
                        ->where('local','en');
    }


    /*
    |--------------------------------------------------------------------------
    | Product Related
    |--------------------------------------------------------------------------
    */

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function productTranslation() //remove
    {
    	$locale = Session::get('currentLocal');
    	return $this->hasOne(ProductTranslation::class,'product_id','product_id')
                ->where('local',$locale);
    }

    public function productTranslationDefaultEnglish() //remove
    {
    	return $this->hasOne(ProductTranslation::class,'product_id','product_id')
                        ->where('local','en');
    }

    public function productBaseImage() //remove
    {
        return $this->hasOne(ProductImage::class,'product_id','product_id');
    }

    public function additionalImage() //remove
    {
        return $this->hasMany(ProductImage::class,'product_id','product_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }


    public function productAttributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class,'product_id','product_id');
    }
}
