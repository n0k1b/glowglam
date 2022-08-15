<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;

class Brand extends Model
{
    use Notifiable;

    protected $fillable = [
        'slug','brand_logo', 'is_active',
    ];

    public $with = ['brandTranslation'];

    public function format()
    {
        return [
            'id'=>$this->id,
            'slug'=>$this->slug,
            'is_active'=>$this->is_active,
            'brand_logo'=>$this->brand_logo ?? null,
            'brand_name'=>$this->brandTranslation->brand_name ?? $this->brandTranslationEnglish->brand_name ?? null,
        ];
    }

    public function products()
    {
    	return $this->hasMany(Product::class,'brand_id');
    }

    public function brandTranslation()
    {
        $locale = Session::get('currentLocal');
        return $this->hasOne(BrandTranslation::class,'brand_id')
                    ->where('local',$locale);
    }

    public function brandTranslationEnglish()
    {
        return $this->hasOne(BrandTranslation::class,'brand_id')
                    ->where('local','en');
    }
}
