<?php

namespace App\Repositories\AttributeSet;

use App\Contracts\AttributeSet\AttributeSetTranslationContract;
use App\Models\AttributeSetTranslation;

class AttributeSetTranslationRepository implements AttributeSetTranslationContract
{
    public function storeAttributeSetTranslation($data){
        return AttributeSetTranslation::create($data);
    }

    public function getByIdAndLocale($attribute_set_id, $locale){
        return AttributeSetTranslation::where('attribute_set_id',$attribute_set_id)->where('locale', $locale)->first();
    }

    public function updateOrInsertAttributeSetTranslation($request){
        AttributeSetTranslation::updateOrCreate(
            ['attribute_set_id'  => $request->attribute_set_id, 'locale' => session('currentLocal')],
            ['attribute_set_name'=> $request->attribute_set_name]
        );
    }

    public function destroy($attribute_set_id){
        AttributeSetTranslation::where('attribute_set_id', $attribute_set_id)->delete();
    }
}
