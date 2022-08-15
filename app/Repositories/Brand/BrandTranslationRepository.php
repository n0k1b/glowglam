<?php

namespace App\Repositories\Brand;

use App\Contracts\Brand\BrandTranslationContract;
use App\Models\BrandTranslation;
use Illuminate\Support\Facades\DB;

class BrandTranslationRepository implements BrandTranslationContract
{
    public function storeBrandTranslation($data){
        return BrandTranslation::create($data);
    }

    public function getByIdAndLocale($brand_id, $locale){
        return BrandTranslation::where('brand_id',$brand_id)->where('local', $locale)->first();
    }

    public function updateOrInsertBrandTranslation($request){
        DB::table('brand_translations')
        ->updateOrInsert(
            ['brand_id' => $request->brand_id, 'local' => session('currentLocal')],
            ['brand_name'=> htmlspecialchars_decode($request->brand_name)]
        );
    }
}
