<?php

namespace App\Contracts\Category;

interface CategoryTranslationContract
{
    public function storeCategoryTranslation($data);

    public function getByIdAndLocale($id, $locale);

    public function updateOrInsertCategoryTranslation($request);

    public function destroy($category_id);

    public function bulkDestroyByIds($category_ids);
}

?>
