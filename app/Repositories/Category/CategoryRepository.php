<?php

namespace App\Repositories\Category;

use App\Contracts\Category\CategoryContract;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Traits\ActiveInactiveTrait;
use App\Traits\DeleteWithFileTrait;

class CategoryRepository implements CategoryContract
{
    use ActiveInactiveTrait, DeleteWithFileTrait;

    public function getAllCategories()
    {
        return Category::with(['catTranslation','parentCategory.catTranslation'])
            ->orderBy('is_active','DESC')
            ->orderBy('id','DESC')
            ->get()
            ->map(function($category){
                return [
                    'id'=>$category->id,
                    'image'=>$category->image,
                    'is_active'=>$category->is_active,
                    'category_name'=>$category->catTranslation->category_name ?? $category->categoryTranslationDefaultEnglish->category_name ?? null,
                    'parent_category_name'=> ($category->parentCategory!=NULL) ? ($category->parentCategory->catTranslation->category_name ?? $category->parentCategory->categoryTranslationDefaultEnglish->category_name) : 'NONE',
                ];
            });


    }

    public function storeCategory($data){
        return Category::create($data);
    }

    public function getById($id){
        return Category::find($id);
    }

    public function updateCategoryById($id, $data){
        return Category::whereId($id)->update($data);
    }

    public function active($id)
    {
        return $this->activeData($this->getById($id));
    }

    public function inactive($id)
    {
        return $this->inactiveData($this->getById($id));
    }

    public function destroy($id){
        $this->deleteWithFile($this->getById($id));
    }

    public function bulkAction($type, $ids)
    {
        return $this->bulkActionData($type, Category::whereIn('id',$ids));
    }

    public function bulkDestroyByIds($ids)
    {
        $this->deleteMultipleDataWithImages(Category::whereIn('id',$ids));

        // CategoryProduct::where('category_id','3')->where('product_id','44')->delete();
    }
}


