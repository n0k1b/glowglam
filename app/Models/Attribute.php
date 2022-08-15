<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Attribute extends Model
{

    protected $fillable = [
        'slug',
        'attribute_set_id',
        'category_id',
        'is_filterable',
        'is_active'
    ];

    //Attribute
    public function attributeTranslation()
    {
        $locale = Session::get('currentLocal');
        return $this->hasOne(AttributeTranslation::class,'attribute_id')
                    ->where('locale',$locale);
    }

    public function attributeTranslationEnglish()
    {
        return $this->hasOne(AttributeTranslation::class,'attribute_id')
                    ->where('locale','en');
    }

    //Attribute Set
    public function attributeSetTranslation()
    {
        $locale = Session::get('currentLocal');
        return $this->hasOne(AttributeSetTranslation::class,'attribute_set_id','attribute_set_id')
                    ->where('locale',$locale);
    }

    public function attributeSetTranslationEnglish()
    {
        return $this->hasOne(AttributeSetTranslation::class,'attribute_set_id','attribute_set_id')
                    ->where('locale','en');
    }

    public function attributeValue()
    {
    	return $this->hasOne(AttributeValue::class,'attribute_id');
    }

    //For AttibuteController
    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class,'attribute_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class); //db: attribute_category
    }


}
