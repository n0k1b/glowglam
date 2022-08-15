<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Setting extends Model
{
    protected $fillable = ['key','is_translatable','plain_value'];

    public function settingTranslations()
    {
    	return $this->hasMany(SettingTranslation::class,'setting_id');
    }

    public function settingTranslation()
    {
        $locale = Session::get('currentLocal');
    	return $this->hasOne(SettingTranslation::class,'setting_id')
                ->where('locale',$locale);
    }

    public function settingTranslationDefaultEnglish()
    {
    	 return $this->hasOne(SettingTranslation::class,'setting_id')
                        ->where('locale','en');
    }

    public function storeFrontImage()
    {
    	return $this->hasOne(StorefrontImage::class,'setting_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class,'plain_value');
    }

    public function pageTranslation()
    {
        $locale = Session::get('currentLocal');
    	return $this->hasOne(PageTranslation::class,'page_id')
                    ->where('locale',$locale);
    }
}
