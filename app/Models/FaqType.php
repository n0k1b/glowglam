<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class FaqType extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_active'
    ];

    public function faqTypeTranslation()
    {
        $locale = Session::get('currentLocal');
        return $this->hasOne(FaqTypeTranslation::class,'faq_type_id')
                    ->where('locale',$locale);
    }

    public function faqTypeTranslationEnglish()
    {
        $locale = 'en';
        return $this->hasOne(FaqTypeTranslation::class,'faq_type_id')
                    ->where('locale',$locale);
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class,'faq_type_id');
    }
}
