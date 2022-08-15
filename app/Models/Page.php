<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Page extends Model
{
    protected $fillable = ['slug','is_active'];

    public function pageTranslations()
    {
    	return $this->hasMany(PageTranslation::class,'page_id');
    }

    public function pageTranslation()
    {
        $locale = Session::get('currentLocal');
    	return $this->hasOne(PageTranslation::class,'page_id')
                    ->where('locale',$locale);
    }

}
