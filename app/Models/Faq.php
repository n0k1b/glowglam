<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'faq_type_id',
        'is_active',
    ];
    // protected $dates = ['deleted_at'];


    public function faqTranslation()
    {
        $locale = Session::get('currentLocal');
        return $this->hasOne(FaqTranslation::class,'faq_id')
                    ->where('locale',$locale);
    }

    public function faqTranslationEnglish()
    {
        $locale = 'en';
        return $this->hasOne(FaqTranslation::class,'faq_id')
                    ->where('locale',$locale);
    }

    public function faqType()
    {
        $locale = Session::get('currentLocal');
        return $this->belongsTo(FaqTypeTranslation::class,'faq_type_id')
                ->where('locale',$locale);
    }
}
