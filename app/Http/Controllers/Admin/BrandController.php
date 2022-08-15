<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\BrandStoreRequest;
use App\Http\Requests\Brand\BrandUpdateRequest;
use App\Services\BrandService;

class BrandController extends Controller
{
    protected $brandService;
    public function __construct(BrandService $brandService){
        $this->brandService = $brandService;
    }


    public function index()
    {
        if (auth()->user()->can('brand-view')){
            $brands =  $this->brandService->getAllBrands();
            if (request()->ajax()){
                return $this->brandService->dataTable($brands);
            }
            return view('admin.pages.brand.index',compact('brands'));
        }
        return abort('403', __('You are not authorized'));
    }

    public function store(BrandStoreRequest $request)
    {
        if (auth()->user()->can('brand-store')){
            return $this->brandService->storeBrand($request);
        }
    }

    public function brandEdit($id)
    {
        $brand = $this->brandService->findBrand($id);
        $brandTranslation = $this->brandService->findBrandTranslation($id); //this id means brand_id
        return view('admin.pages.brand.edit',compact('brand','brandTranslation'));
    }

    public function brandUpdate(BrandUpdateRequest $request, $id)
    {
        if (auth()->user()->can('brand-edit')){
            return $this->brandService->updateBrand($request);
        }
    }


    public function active(Request $request){
        if ($request->ajax()){
            return $this->brandService->activeById($request->id);
        }
    }

    public function inactive(Request $request){
        if ($request->ajax()){
            return $this->brandService->inactiveById($request->id);
        }
    }

    public function bulkAction(Request $request){
        if ($request->ajax()) {
            return $this->brandService->bulkActionByTypeAndIds($request->action_type, $request->idsArray);
        }
    }

}
