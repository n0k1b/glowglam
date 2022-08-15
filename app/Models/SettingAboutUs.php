<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class SettingAboutUs extends Model
{
    use HasFactory;

    protected $fillable = ['status','image'];

    public function aboutUsTranslation()
    {
        $locale = Session::get('currentLocal');
        return $this->hasOne(SettingAboutUsTranslation::class,'setting_about_us_id')
                    ->where('locale',$locale);
    }

    public function aboutUsTranslationEnglish()
    {
        $locale = 'en';
        return $this->hasOne(SettingAboutUsTranslation::class,'setting_about_us_id')
                    ->where('locale',$locale);
    }

}
