<?php

namespace App\Contracts\Brand;

interface BrandTranslationContract
{
    public function storebrandTranslation($data);

    public function getByIdAndLocale($brand_id, $locale);

    public function updateOrInsertBrandTranslation($request);
}
