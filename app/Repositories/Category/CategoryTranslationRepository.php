<?php

namespace App\Repositories\Category;

use App\Contracts\Category\CategoryTranslationContract;
use App\Models\CategoryTranslation;
use App\Traits\DeleteWithFileTrait;
use Illuminate\Support\Facades\DB;

class CategoryTranslationRepository implements CategoryTranslationContract
{
    use DeleteWithFileTrait;

    public function storeCategoryTranslation($data){
        return CategoryTranslation::create($data);
    }

    public function getByIdAndLocale($id, $locale){
        return CategoryTranslation::where('category_id',$id)->where('local', $locale)->first();
    }

    public function updateOrInsertCategoryTranslation($request){
        DB::table('category_translations')
        ->updateOrInsert(
            ['category_id' => $request->category_id, 'local' => session('currentLocal')],
            ['category_name'=> htmlspecialchars_decode($request->category_name)]
        );
    }

    public function destroy($category_id){
        CategoryTranslation::where('category_id', $category_id)->delete();
    }

    public function bulkDestroyByIds($category_ids){
        CategoryTranslation::whereIn('category_id', $category_ids)->delete();
    }

}
