<?php

namespace App\Models;

use App\Traits\TranslationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;

class AttributeSet extends Model
{
    use TranslationTrait, SoftDeletes;


    protected $fillable = ['is_active'];
    protected $dates = ['deleted_at'];


    //New
    public function attributeSetTranslations()
    {
        $locale = Session::get('currentLocal');
        return $this->hasMany(AttributeSetTranslation::class,'attribute_set_id')
                    ->where('locale',$locale)
                    ->orWhere('locale','en');
    }
    //New
    public function format()
    {
        return [
            'id'=>$this->id,
            'is_active'=>$this->is_active,
            'attribute_set_name'=> $this->translations($this->attributeSetTranslations)->attribute_set_name ?? null
        ];
    }



    // Previous
    public function attributeSetTranslation()
    {
        $locale = Session::get('currentLocal');
        return $this->hasOne(AttributeSetTranslation::class,'attribute_set_id')
                    ->where('locale',$locale);
    }

    public function attributeSetTranslationEnglish()
    {
        return $this->hasOne(AttributeSetTranslation::class,'attribute_set_id')
                    ->where('locale','en');
    }

    //For Product
    public function attributes()
    {
    	return $this->hasMany(Attribute::class,'attribute_set_id');
    }
}
