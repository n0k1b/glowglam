<?php

namespace App\Services;

use App\Contracts\Category\CategoryContract;
use App\Contracts\Category\CategoryTranslationContract;
use App\Traits\imageHandleTrait;
use App\Traits\SlugTrait;
use Illuminate\Support\Facades\File;

class CategoryService
{
    use SlugTrait, imageHandleTrait;

    private $categoryContract;
    private $categoryTranslationContract;
    public function __construct(CategoryContract $categoryContract, CategoryTranslationContract $categoryTranslationContract)
    {
        $this->categoryContract            = $categoryContract;
        $this->categoryTranslationContract = $categoryTranslationContract;
    }

    public function getAllCategories()
    {
        $data = $this->categoryContract->getAllCategories();
        return json_decode(json_encode($data), FALSE);
    }

    public function dataTable()
    {
        $categories = $this->getAllCategories();

        return datatables()->of($categories)
                ->setRowId(function ($category){
                    return $category->id;
                })
                ->addColumn('category_image', function ($row){
                    if ($row->image==null) {
                        return '<img src="'.url("public/images/empty.jpg").'" alt="" height="50px" width="50px">';
                    }
                    else {
                        if (!File::exists(public_path($row->image))) {
                            $url = 'https://dummyimage.com/50x50/000000/0f6954.png&text=Category';
                        }else {
                            $url = url("public/".$row->image);
                        }
                        return  '<img src="'. $url .'" height="50px" width="50px"/>';
                    }
                })
                ->addColumn('category_name', function ($row){
                    return $row->category_name;
                })
                ->addColumn('parent', function ($row){
                    return $row->parent_category_name;
                })
                ->addColumn('is_active', function ($row){
                    if($row->is_active==1){
                        return '<span class="p-2 badge badge-success">Active</span>';
                    }else{
                        return '<span class="p-2 badge badge-danger">Inactive</span>';
                    }
                })
                ->addColumn('action', function ($row){
                    $actionBtn = "";
                    if (auth()->user()->can('category-edit')){
                        $actionBtn .= '<button type="button" title="Edit" class="edit btn btn-info btn-sm" title="Edit" data-id="'.$row->id.'"><i class="dripicons-pencil"></i></button>
                                        &nbsp; ';
                    }
                    if (auth()->user()->can('category-action')){
                        if ($row->is_active==1) {
                            $actionBtn .= '<button type="button" title="Inactive" class="inactive btn btn-warning btn-sm" data-id="'.$row->id.'"><i class="fa fa-thumbs-down"></i></button>';
                        }else {
                            $actionBtn .= '<button type="button" title="Active" class="active btn btn-success btn-sm" data-id="'.$row->id.'"><i class="fa fa-thumbs-up"></i></button>';
                        }
                        // $actionBtn .= '<button type="button" title="Delete" class="delete btn btn-danger btn-sm ml-2" title="Edit" data-id="'.$row->id.'"><i class="dripicons-trash"></i></button>
                        // &nbsp; ';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['is_active','action','category_image'])
                ->make(true);
    }

    public function storeCategory($request)
    {
        if (env('USER_VERIFIED')!=1) {
            return response()->json(['demo' => 'Disabled for demo !']);
        }
        $data = $this->requestHandleData($request, null);
        $category =  $this->categoryContract->storeCategory($data);

        $dataTranslation  = [];
        $dataTranslation['category_id']   = $category->id;
        $dataTranslation['local']         = session('currentLocal');
        $dataTranslation['category_name'] = htmlspecialchars_decode($request->category_name);
        $this->categoryTranslationContract->storeCategoryTranslation($dataTranslation);
        return response()->json(['success' => __('Data Successfully Saved')]);
    }

    public function findCategory($id)
    {
        return $this->categoryContract->getById($id);
    }

    public function findCategoryTranslation($id)
    {
        $categoryTranslation = $this->categoryTranslationContract->getByIdAndLocale($id,session('currentLocal'));
        if (!isset($categoryTranslation)) {
            $categoryTranslation =  $this->categoryTranslationContract->getByIdAndLocale($id,'en');
        }
        return $categoryTranslation;
    }

    public function updateCategory($request)
    {
        if (env('USER_VERIFIED')!=1) {
            return response()->json(['demo' => 'Disabled for demo !']);
        }
        $category = $this->findCategory($request->category_id);
        $data     = $this->requestHandleData($request, $category);
        $this->categoryContract->updateCategoryById($request->category_id, $data);
        $this->categoryTranslationContract->updateOrInsertCategoryTranslation($request);
        return response()->json(['success' => 'Data Updated Successfully']);
    }


    public function requestHandleData($request, $category){
        $data              = [];
        $data['slug']      = $this->slug(htmlspecialchars_decode($request->category_name));
        $data['parent_id'] = ($request->parent_id==true) ? $request->parent_id : null;
        $data['icon']      = ($request->icon==true) ? $request->icon : null;
        $data['top']       = ($request->top==true) ? $request->top : 0;
        $data['is_active'] = ($request->is_active==true) ? $request->is_active : 0;
        if ($request->image) {
            if ($category) {
                $this->previousImageDelete($category->image);
            }
            $data['image'] = $this->imageStore($request->image, $directory='images/categories/',$type='category');
        }
        return $data;
    }


    public function activeById($id)
    {
        if (env('USER_VERIFIED')!=1) {
            return response()->json(['demo' => 'Disabled for demo !']);
        }
        return $this->categoryContract->active($id);
    }

    public function inactiveById($id)
    {
        if (env('USER_VERIFIED')!=1) {
            return response()->json(['demo' => 'Disabled for demo !']);
        }
        return $this->categoryContract->inactive($id);
    }

    public function destroy($category_id){
        if (env('USER_VERIFIED')!=1) {
            return response()->json(['demo' => 'Disabled for demo !']);
        }
        $this->categoryContract->destroy($category_id);
        $this->categoryTranslationContract->destroy($category_id);
        return response()->json(['success' => 'Data Deleted Successfully']);
    }

    public function bulkActionByTypeAndIds($type, $ids){
        if (env('USER_VERIFIED')!=1) {
            return response()->json(['demo' => 'Disabled for demo !']);
        }
        return $this->categoryContract->bulkAction($type, $ids);
    }

    public function bulkDestroy($category_ids){
        if (env('USER_VERIFIED')!=1) {
            return response()->json(['demo' => 'Disabled for demo !']);
        }
        $this->categoryContract->bulkDestroyByIds($category_ids);
        $this->categoryTranslationContract->bulkDestroyByIds($category_ids);
        return response()->json(['success' => 'Data Deleted Successfully']);
    }
}
?>
