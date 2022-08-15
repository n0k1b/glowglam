<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class ProductAttributeValue extends Model
{
    protected $table = 'product_attribute_value';

    protected $fillable = ['product_id','attribute_id','attribute_value_id'];



    //Used HomeController for product-details;
    public function attributeTranslation()
    {
        $locale = Session::get('currentLocal');
        return $this->hasOne(AttributeTranslation::class,'attribute_id','attribute_id')
                    ->where('locale',$locale);
    }
    public function attributeTranslationEnglish()
    {
        return $this->hasOne(AttributeTranslation::class,'attribute_id','attribute_id')
                    ->where('locale','en');
    }



    //Frontend/HomeController index()
    public function attrValueTranslation()
    {
        $locale = Session::get('currentLocal');
    	return $this->hasone(AttributeValueTranslation::class,'attribute_value_id','attribute_value_id')
                    ->where('local',$locale);
    }
    public function attrValueTranslationEnglish()
    {
    	return $this->hasone(AttributeValueTranslation::class,'attribute_value_id','attribute_value_id')
                    ->where('local','en');
    }


    //For ProductController index()
    public function attributeValueTranslations()
    {
        $locale = Session::get('currentLocal');
        return $this->hasMany(AttributeValueTranslation::class,'attribute_id','attribute_id')
                ->where('local',$locale);
                // ->orWhere('local','en');
    }
}
