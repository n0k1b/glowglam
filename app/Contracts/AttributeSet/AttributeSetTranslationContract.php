<?php

namespace App\Contracts\AttributeSet;

interface AttributeSetTranslationContract
{
    public function storeAttributeSetTranslation($data);

    public function getByIdAndLocale($attribute_set_id, $locale);

    public function updateOrInsertAttributeSetTranslation($request);

    public function destroy($attribute_set_id);
}
