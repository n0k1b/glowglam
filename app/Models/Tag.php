<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Tag extends Model
{
    protected $fillable = [
        'slug',
        'is_active'
    ];

    public function tagTranslation()  //Remove Later
    {
    	return $this->hasMany(TagTranslation::class,'tag_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }



    //Use tagTranslations and tagTranslationEnglish used in Category Wise Products
    public function tagTranslations()
    {
        $locale = Session::get('currentLocal');
        return $this->hasOne(TagTranslation::class,'tag_id')
                    ->where('local',$locale);

        //****************** Test  *******************

        // $locale = 'kl';
        // return  $this->hasOne(TagTranslation::class,'tag_id')
        //               ->where('local', $locale ?? 'en')
        //               ->select('tag_id','tag_name','local');  //??

                    //   $this->hasOne(TagTranslation::class,'tag_id')
                    //   ->where('local','bn')
                    //   ->select('tag_id','tag_name','local');

        // $query->hasOne(TagTranslation::class,'tag_id')
        //             ->where('local','en');

                // ->when(isset($locale), function ($query) use ($locale) {
                //     $query->where('local', 'nn');
                // })
                // ->when(isset($locale), function ($query) use ($locale) {
                //     $query->where('local', 'en');
                // });

        // if ($data) {
        //     return 'ok';
        // }
        // else {
        //     return $this->tagTranslationEnglish();
        // }


    }

    public function tagTranslationEnglish()
    {
        return $this->hasOne(TagTranslation::class,'tag_id')
                    ->where('local','en');
    }
}
