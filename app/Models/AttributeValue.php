<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class AttributeValue extends Model
{
    protected $fillable = [
        'attribute_id',
        'position'
    ];

    public function attributeValueTranslation() // Remove later
    {
    	return $this->hasMany(AttributeValueTranslation::class,'attribute_value_id');
    }


    public function attrValueTranslation()
    {
        $locale = Session::get('currentLocal');
    	return $this->hasone(AttributeValueTranslation::class,'attribute_value_id')
                    ->where('local',$locale);
    }

    public function attrValueTranslationEnglish()
    {
    	return $this->hasone(AttributeValueTranslation::class,'attribute_value_id')
                    ->where('local','en');
    }
}
