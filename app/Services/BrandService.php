<?php

namespace App\Services;

use App\Contracts\Brand\BrandContract;
use App\Contracts\Brand\BrandTranslationContract;
use App\Traits\imageHandleTrait;
use App\Traits\SlugTrait;
use Illuminate\Support\Facades\File;

class BrandService
{
    use SlugTrait, imageHandleTrait;

    private $brandContract;
    private $brandTranslationContract;
    public function __construct(BrandContract $brandContract, BrandTranslationContract $brandTranslationContract)
    {
        $this->brandContract            = $brandContract;
        $this->brandTranslationContract = $brandTranslationContract;
    }

    public function getAllBrands()
    {
        return $this->brandContract->getAllBrands();
    }

    public function dataTable($data)
    {
        $brands = json_decode(json_encode($data), FALSE);

        return datatables()->of($brands)
                ->setRowId(function ($row){
                    return $row->id;
                })
                ->addColumn('brand_logo', function ($row)
                {
                    if ($row->brand_logo==null) {
                        $url = 'https://dummyimage.com/50x50/000000/0f6954.png&text=Brand';
                    }
                    elseif ($row->brand_logo!=null) {
                        if (!File::exists(public_path($row->brand_logo))) {
                            $url = 'https://dummyimage.com/50x50/000000/0f6954.png&text=Brand';
                        }else {
                            $url = url("public/".$row->brand_logo);
                        }
                    }
                    return  '<img src="'. $url .'" height="50px" width="50px"/>';
                })
                ->addColumn('brand_name', function ($row)
                {
                    return $row->brand_name;
                })
                ->addColumn('action', function ($row)
                {
                    $actionBtn = "";
                    if (auth()->user()->can('brand-edit')){
                        $actionBtn .= '<a href="'.route('admin.brand.edit', $row->id) .'" class="edit btn btn-primary btn-sm" title="Edit"><i class="dripicons-pencil"></i></a>
                        &nbsp; ';
                    }
                    if (auth()->user()->can('brand-action')){
                        if ($row->is_active==1) {
                            $actionBtn .= '<button type="button" title="Inactive" class="inactive btn btn-danger btn-sm" data-id="'.$row->id.'"><i class="fa fa-thumbs-down"></i></button>';
                        }else {
                            $actionBtn .= '<button type="button" title="Active" class="active btn btn-success btn-sm" data-id="'.$row->id.'"><i class="fa fa-thumbs-up"></i></button>';
                        }
                    }
                    return $actionBtn;
                })
                ->rawColumns(['brand_logo','action'])
                ->make(true);
    }

    public function storeBrand($request)
    {
        if (env('USER_VERIFIED')!=1) {
            return response()->json(['demo' => 'Disabled for demo !']);
        }
        $data  = $this->requestHandleData($request, $brand = null);
        $brand = $this->brandContract->storeBrand($data);

        $dataTranslation  = [];
        $dataTranslation['brand_id']   = $brand->id;
        $dataTranslation['local']      = session('currentLocal');
        $dataTranslation['brand_name'] = htmlspecialchars_decode($request->brand_name);
        $this->brandTranslationContract->storeBrandTranslation($dataTranslation);
        return response()->json(['success' => __('Data Successfully Saved')]);
    }

    public function findBrand($id)
    {
        return $this->brandContract->getById($id);
    }

    public function findBrandTranslation($brand_id)
    {
        $brandTranslation = $this->brandTranslationContract->getByIdAndLocale($brand_id,session('currentLocal'));
        if (!isset($brandTranslation)) {
            $brandTranslation =  $this->brandTranslationContract->getByIdAndLocale($brand_id,'en');
        }
        return $brandTranslation;
    }

    public function updateBrand($request)
    {
        if (env('USER_VERIFIED')!=1) {
            session()->flash('type','danger');
            session()->flash('message','Disabled for demo !');
            return redirect()->back();
        }
        $brand = $this->findBrand($request->brand_id);
        $data     = $this->requestHandleData($request, $brand);
        $this->brandContract->updateBrandById($request->brand_id, $data);
        $this->brandTranslationContract->updateOrInsertBrandTranslation($request);

        session()->flash('type','success');
        session()->flash('message','Successfully Updated');
        return redirect()->back();
    }

    protected function requestHandleData($request, $brand)
    {
        $data              = [];
        $data['slug']      = $this->slug(htmlspecialchars_decode($request->brand_name));
        $data['is_active'] = ($request->is_active==true) ? 1 : 0;
        if ($request->brand_logo) {
            if ($brand) {
                $this->previousImageDelete($brand->brand_logo);
            }
            $data['brand_logo'] = $this->imageStore($request->brand_logo, $directory='images/brands/', $type='brand');
        }
        return $data;
    }

    public function activeById($id)
    {
        if (env('USER_VERIFIED')!=1) {
            return response()->json(['demo' => 'Disabled for demo !']);
        }
        return $this->brandContract->active($id);
    }

    public function inactiveById($id)
    {
        if (env('USER_VERIFIED')!=1) {
            return response()->json(['demo' => 'Disabled for demo !']);
        }
        return $this->brandContract->inactive($id);
    }

    public function bulkActionByTypeAndIds($type, $ids)
    {
        if (env('USER_VERIFIED')!=1) {
            return response()->json(['demo' => 'Disabled for demo !']);
        }
        return $this->brandContract->bulkAction($type, $ids);
    }
}
