<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeSet;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductImage;
use App\Models\ProductTranslation;
use App\Models\Tag;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Traits\ActiveInactiveTrait;
use App\Traits\SlugTrait;
use Image;
use Str;
use App\Traits\FormatNumberTrait;
use App\Traits\DeleteWithFileTrait;
use Illuminate\Support\Facades\App;
use App\Services\BrandService;
use App\Traits\imageHandleTrait;

class ProductController extends Controller
{
    use ActiveInactiveTrait, SlugTrait, FormatNumberTrait, DeleteWithFileTrait, imageHandleTrait;

    protected $brandService;
    public function __construct(BrandService $brandService){
        $this->brandService = $brandService;
    }


    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    |
    |
    */

    public function index()
    {
        if (auth()->user()->can('product-view'))
        {
            $local = Session::get('currentLocal');
            App::setLocale($local);

            $products = Product::with('baseImage','productTranslation','productTranslationEnglish')
                        ->orderBy('is_active','DESC')
                        ->orderBy('id','DESC')
                        ->get();


            if (request()->ajax())
            {
                return datatables()->of($products)
                ->setRowId(function ($row){
                    return $row->id;
                })
                ->addColumn('image', function ($row)
                {
                    if (($row->baseImage==null) || ($row->baseImage->type!='base')) {
                        $url = 'https://dummyimage.com/50x50/000/fff';
                    }elseif ($row->baseImage->type=='base') {
                        if (!File::exists(public_path($row->baseImage->image_small))) {
                            $url = 'https://dummyimage.com/50x50/000/fff';
                        }else {
                            $url = url("public/".$row->baseImage->image_small);
                        }
                    }
                    return '<img src="'. $url .'" height="50px" width="50px"/>';
                })
                ->addColumn('product_name', function ($row)
                {
                    return $row->productTranslation->product_name ?? $row->productTranslationEnglish->product_name ?? null;
                })
                ->addColumn('price', function ($row)
                {
                    if ($row->special_price > 0) {
                        return  '<span>'.number_format((float)$row->special_price, env('FORMAT_NUMBER'), '.', '').'</span></br><span class="text-danger"><del>'.number_format((float)$row->price, env('FORMAT_NUMBER'), '.', '').'</del></span>';
                    }else {
                        return '$'.number_format((float)$row->price, env('FORMAT_NUMBER'), '.', '');
                    }
                })
                ->addColumn('action', function ($row)
                {
                    $actionBtn = "";
                    if (auth()->user()->can('product-edit'))
                    {
                        $actionBtn .= '<a href="'.route('admin.products.edit', $row->id) .'" class="edit btn btn-primary btn-sm" title="Edit"><i class="dripicons-pencil"></i></a>
                        &nbsp; ';
                    }
                    if (auth()->user()->can('product-action'))
                    {
                        if ($row->is_active==1) {
                            $actionBtn .= '<button type="button" title="Inactive" class="inactive btn btn-warning btn-sm" data-id="'.$row->id.'"><i class="fa fa-thumbs-down"></i></button> &nbsp';;
                        }else {
                            $actionBtn .= '<button type="button" title="Active" class="active btn btn-success btn-sm" data-id="'.$row->id.'"><i class="fa fa-thumbs-up"></i></button>  &nbsp';
                        }
                    }
                        // $actionBtn .= '<a  onclick="return confirm(\'Are you sure to delete ?\')" href="'.route('admin.products.delete', $row->id) .'" class="delete btn btn-danger btn-sm" title="Delete"><i class="dripicons-trash"></i></a>';

                    return $actionBtn;
                })
                ->rawColumns(['image','action','price'])
                ->make(true);
            }
            return view('admin.pages.product.index');
        }
        return abort('403', __('You are not authorized'));

    }

    /*
    |--------------------------------------------------------------------------
    | Product Create
    |--------------------------------------------------------------------------
    |
    |
    */

    public function create()
    {
        $local = Session::get('currentLocal');
        App::setLocale($local);

        $brands = json_decode(json_encode($this->brandService->getAllBrands()), FALSE);

        $categories = Category::with(['categoryTranslation'=> function ($query) use ($local){
                $query->where('local',$local)
                ->orWhere('local','en')
                ->orderBy('id','DESC');
            }])
            ->where('is_active',1)
            ->get();

        $tags = Tag::with(['tagTranslation'=> function ($query) use ($local){
            $query->where('local',$local)
            ->orWhere('local','en')
            ->orderBy('id','DESC');
        }])->get();

        $attributeSets = AttributeSet::with('attributeSetTranslation','attributeSetTranslationEnglish','attributes.attributeTranslation',
                                    'attributes.attributeTranslationEnglish','attributes.attributeValues.attributeValueTranslation')
                                    ->where('is_active',1)
                                    ->orderBy('is_active','DESC')
                                    ->orderBy('id','DESC')
                                    ->get();

        //No Need
        $attributes = Attribute::with('attributeTranslation','attributeTranslationEnglish')
                    ->where('is_active',1)
                    ->get();

        $taxes = Tax::with('taxTranslation','taxTranslationDefaultEnglish')
                ->where('is_active',1)
                ->orderBy('is_active','DESC')
                ->orderBy('id','ASC')
                ->get();

        return view('admin.pages.product.create',compact('local','brands','categories','tags','attributeSets','attributes','taxes'));
    }

    /*
    |--------------------------------------------------------------------------
    | Product Store
    |--------------------------------------------------------------------------
    |
    |
    */

    public function store(Request $request)
    {
        if (env('USER_VERIFIED')!=1) {
            session()->flash('type','danger');
            session()->flash('message','Disabled for demo !');
            return redirect()->back();
        }

        $validator = Validator::make($request->all(),[
            'product_name'=> 'required|unique:product_translations',
            'description' => 'required',
            'price'       => 'required',
            'sku'         => 'required|unique:products',
            'base_image'  => 'image|max:10240|mimes:jpeg,png,jpg,gif,webp',
            'category_id'  => 'required',
            'tax_id'  => 'required',
        ]);

        if ($validator->fails()){
            session()->flash('type','danger');
            session()->flash('message','Something Wrong');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->new_from > $request->new_to) {
            session()->flash('type','danger');
            session()->flash('message','The From date should not be greater then the To date');
            return redirect()->back();
        }

        $local = Session::get('currentLocal');

        if (auth()->user()->can('product-store'))
        {

                $product                = new Product();
                if ($request->brand_id) {
                    $product->brand_id  = $request->brand_id;
                }
                $product->tax_id        = $request->tax_id;
                $product->slug          = $this->slug(htmlspecialchars_decode($request->product_name));
                $product->price         = $request->price;

                $product->special_price = number_format((float)$request->special_price, env('FORMAT_NUMBER'), '.', '');

                if ($request->special_price && $request->price > $request->special_price){
                    $product->is_special = 1;
                }else {
                    $product->is_special = 0;
                }
                $product->special_price_type = $request->special_price_type;
                $product->special_price_start= $request->special_price_start==true ? date("Y-m-d",strtotime($request->special_price_start)): null;
                $product->special_price_end  = $request->special_price_end==true ? date("Y-m-d",strtotime($request->special_price_end)): null;
                $product->selling_price = number_format((float)$request->special_price, env('FORMAT_NUMBER'), '.', '');
                $product->sku           = $request->sku;
                $product->manage_stock  = $request->manage_stock==0 ? 0:1;
                $product->qty           = $request->qty;
                $product->in_stock      = $request->in_stock==0 ? 0:1;
                $product->new_from      = $request->new_from==true ? date("Y-m-d",strtotime($request->new_from)): null;
                $product->new_to        = $request->new_to==true ? date("Y-m-d",strtotime($request->new_to)): null;
                $product->avg_rating    = 0;
                $product->is_active     = $request->is_active==0 ? 0 : 1;
                $product->save();

                //----------------- Product Translation --------------

                $productTranslation = new ProductTranslation();
                $productTranslation->product_id  = $product->id;
                $productTranslation->local        = Session::get('currentLocal');
                $productTranslation->product_name = htmlspecialchars_decode($request->product_name);
                $productTranslation->description  = htmlspecialchars_decode($request->description);;
                $productTranslation->short_description  = $request->short_description;
                $productTranslation->save();

                //----------------- Base Image --------------
                if (!empty($request->base_image)){
                    $image_name = $this->imageStoreProduct($request->base_image);

                    $productImage = [];
                    $productImage['product_id'] = $product->id;
                    $productImage['image']        = '/images/products/large/'.$image_name;
                    $productImage['image_medium'] = '/images/products/medium/'.$image_name;
                    $productImage['image_small']  = '/images/products/small/'.$image_name;
                    $productImage['type']       = 'base';
                    ProductImage::insert($productImage);
                }

                //----------------- Multiple Image ---------------
                if (!empty($request->additional_images)) {
                    $additionalImagesArray = $request->additional_images;
                    foreach($additionalImagesArray as $key => $image){
                        $image_name = $this->imageStoreProduct($image);
                        $data = [];
                        $data['product_id'] = $product->id;
                        $data['image']        = '/images/products/large/'.$image_name;
                        $data['image_medium'] = '/images/products/medium/'.$image_name;
                        $data['image_small']  = '/images/products/small/'.$image_name;
                        $data['type']  = 'additional';

                        ProductImage::insert($data);
                    }
                }

                //----------------- Category-Product --------------
                if (!empty($request->category_id)) {
                    $categoryArrayIds = $request->category_id;
                    $product->categories()->sync($categoryArrayIds);
                }


                //-----------------Product-Tag--------------
                if (!empty($request->tag_id)) {
                    $tagArrayIds = $request->tag_id;
                    $product->tags()->sync($tagArrayIds);
                }


                //-----------------Product-Attribute--------------

                if ($request->attribute_id[0]) {
                    $attributeArrayIds =  $request->attribute_id;//Array
                    $attributeValueIds = $request->attribute_value_id; //Array
                    for ($i=0; $i <count($attributeArrayIds) ; $i++) {
                        $product->attributes()->attach([$attributeArrayIds[$i]=>['attribute_value_id'=>$attributeValueIds[$i]]]);
                    }
                }

                session()->flash('type','success');
                session()->flash('message','Data Saved Successfully.');

                return redirect()->back();
        }
    }



    /*
    |--------------------------------------------------------------------------
    | Product Edit
    |--------------------------------------------------------------------------
    |
    |
    */

    public function edit($id)
    {
        $local = Session::get('currentLocal');
        App::setLocale($local);

        $product = Product::with(['productTranslation','productTranslationEnglish','categories','tags','brand','brandTranslation','brandTranslationEnglish',
                    'baseImage'=> function ($query){
                        $query->where('type','base')
                            ->first();
                    },
                    'additionalImage'=> function ($query){
                        $query->where('type','additional')
                            ->get();
                    }
                    ])
                    ->where('id',$id)
                    ->first();


        $brands = Brand::with(['brandTranslation','brandTranslationEnglish'])
            ->where('is_active',1)
            ->get();

        $categories = Category::with(['categoryTranslation'=> function ($query) use ($local){
                $query->where('local',$local)
                ->orWhere('local','en')
                ->orderBy('id','DESC');
            }])
            ->where('is_active',1)
            ->get();

        $tags = Tag::with(['tagTranslation'=> function ($query) use ($local){
            $query->where('local',$local)
            ->orWhere('local','en')
            ->orderBy('id','DESC');
        }])->get();

        $attributes = Attribute::with('attributeTranslation','attributeTranslationEnglish','attributeValues')
                        ->where('is_active',1)
                        ->get();

        $attribute_values = AttributeValue::with('attrValueTranslation','attrValueTranslationEnglish')->get();

        $attributeSets = AttributeSet::with('attributeSetTranslation','attributeSetTranslationEnglish','attributes.attributeTranslation',
                        'attributes.attributeTranslationEnglish','attributes.attributeValues.attributeValueTranslation')
                        ->where('is_active',1)
                        ->orderBy('is_active','DESC')
                        ->orderBy('id','DESC')
                        ->get();


        $taxes = Tax::with('taxTranslation','taxTranslationDefaultEnglish')
                ->where('is_active',1)
                ->orderBy('is_active','DESC')
                ->orderBy('id','ASC')
                ->get();

        $format_number = $this->totalFormatNumber();

        return view('admin.pages.product.edit',compact('local','brands','categories','tags','attributes','product','format_number','taxes','attribute_values','attributeSets'));
    }


    /*
    |--------------------------------------------------------------------------
    | Product Update
    |--------------------------------------------------------------------------
    |
    |
    */

    public function update(Request $request, $id)
    {
        if (env('USER_VERIFIED')!=1) {
            session()->flash('type','danger');
            session()->flash('message','Disabled for demo !');
            return redirect()->back();
        }

        $validator = Validator::make($request->all(),[
            'product_name'=> 'required|max:255|unique:product_translations,product_name,'.$request->product_translation_id,
            'description' => 'required',
            'price'       => 'required',
            'base_image'  => 'image|max:10240|mimes:jpeg,png,jpg,gif,webp',
            'category_id'  => 'required',
            'sku'=> 'required|unique:products,sku,'.$id,
            'brand_id' => 'nullable',
            'tax_id' => 'required',
        ]);

        if ($validator->fails()){
            session()->flash('type','danger');
            session()->flash('message','Something Wrong');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->new_from > $request->new_to) {
            session()->flash('type','danger');
            session()->flash('message','The From date should not be greater then the To date');
            return redirect()->back();
        }

        if (auth()->user()->can('product-edit'))
        {
            $local = Session::get('currentLocal');

            $product                = Product::find($id);
            if ($request->brand_id) {
                $product->brand_id      = $request->brand_id;
            }
            if (session('currentLocal')=='en') {
                $product->slug          = $this->slug(htmlspecialchars_decode($request->product_name));
            }
            $product->tax_id        = $request->tax_id;
            $product->price         = $request->price; //1st option
            $product->special_price = number_format((float)$request->special_price, env('FORMAT_NUMBER'), '.', ''); //2nd option

            if ($request->special_price && $request->price > $request->special_price){
                $product->is_special = 1;
            }else {
                $product->is_special = 0;
            }
            $product->special_price_type = $request->special_price_type;
            $product->special_price_start= $request->special_price_start==true ? date("Y-m-d",strtotime($request->special_price_start)) : null;
            $product->special_price_end  = $request->special_price_end==true ? date("Y-m-d",strtotime($request->special_price_end)) : null;

            $product->selling_price = number_format((float)$request->special_price, env('FORMAT_NUMBER'), '.', '');
            $product->sku           = $request->sku;
            $product->manage_stock  = $request->manage_stock;
            $product->qty           = $request->qty;
            $product->in_stock      = $request->in_stock;
            $product->new_from      = $request->new_from==true ? date("Y-m-d",strtotime($request->new_from)) : null;
            $product->new_to        = $request->new_to==true ? date("Y-m-d",strtotime($request->new_to)) : null;

            if ($request->is_active==1) {
                $product->is_active = 1;
            }else {
                $product->is_active = 0;
            }
            $product->update();

            //---Product Update---
            DB::table('product_translations')
            ->updateOrInsert(
                [
                    'product_id'  => $id,
                    'local'       => $local,
                ],
                [
                    'product_name'      => htmlspecialchars_decode($request->product_name),
                    'description'       => htmlspecialchars_decode($request->description),
                    'short_description' => $request->short_description,
                ]
            );


             //-- Base Image ----------
             if (!empty($request->base_image)){
                $productImage = ProductImage::where('product_id',$id)->where('type','base')->first();
                if ($productImage) {
                    if (File::exists(public_path().$productImage->image)) {
                        File::delete(public_path().$productImage->image);
                        File::delete(public_path().$productImage->image_medium);
                        File::delete(public_path().$productImage->image_small);
                    }
                    $image_name = $this->imageStoreProduct($request->base_image);
                    $productImage->image  = '/images/products/large/'.$image_name;
                    $productImage->image_medium  = '/images/products/medium/'.$image_name;
                    $productImage->image_small  = '/images/products/small/'.$image_name;
                    $productImage->update();
                }else {
                    //check this line later
                    $image_name = $this->imageStoreProduct($request->base_image);

                    $productImage = new ProductImage();
                    $productImage->product_id = $id;
                    $productImage->image  = '/images/products/large/'.$image_name;
                    $productImage->image_medium  = '/images/products/medium/'.$image_name;
                    $productImage->image_small  = '/images/products/small/'.$image_name;
                    $productImage->type  = 'base';
                    $productImage->save();
                }
            }


            //----------------- Multiple Image ---------------
            if (!empty($request->additional_images)) {
                $data = ProductImage::where('product_id',$id)->where('type','additional')->get();
                foreach ($data as $key => $value) {

                    if (File::exists(public_path().$value->image)) {
                        File::delete(public_path().$value->image);
                        File::delete(public_path().$value->image_medium);
                        File::delete(public_path().$value->image_small);
                        $data[$key]->delete();
                    }
                }
                $additionalImagesArray = $request->additional_images;
                foreach($additionalImagesArray as $key => $image){
                    $image_name = $this->imageStoreProduct($image);
                    $productImage = new ProductImage();
                    $productImage->product_id = $id;
                    $productImage->image = '/images/products/large/'.$image_name;
                    $productImage->image_medium = '/images/products/medium/'.$image_name;
                    $productImage->image_small = '/images/products/small/'.$image_name;
                    $productImage->type  = 'additional';
                    $productImage->save();
                }
            }


            //----------------- Category-Product --------------
            if (!empty($request->category_id)) {
                $categoryArrayIds = $request->category_id;
                $product->categories()->sync($categoryArrayIds);
            }

            //-----------------Product-Tag--------------
            if (!empty($request->tag_id)) {
                $tagArrayIds = $request->tag_id;
                $product->tags()->sync($tagArrayIds);
            }

            //-----------------Product-Attribute-------------


            if ($request->attribute_id[0]) {
                ProductAttributeValue::where('product_id',$product->id)->delete();
                $attributeArrayIds =  $request->attribute_id;//Array
                $attributeValueIds = $request->attribute_value_id; //Array
                for ($i=0; $i <count($attributeArrayIds) ; $i++) {
                    $product->attributes()->attach([$attributeArrayIds[$i]=>['attribute_value_id'=>$attributeValueIds[$i]]]);
                }
            }
            session()->flash('type','success');
            session()->flash('message','Data Updated Successfully.');

            return redirect()->back();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Product Active-Inactive
    |--------------------------------------------------------------------------
    |
    |
    */

    public function active(Request $request){
        if ($request->ajax()){
            if (env('USER_VERIFIED')!=1) {
                return response()->json(['errors' => ['Disabled for demo !']]);
            }
            return $this->activeData(Product::find($request->id));
        }
    }

    public function inactive(Request $request){
        if ($request->ajax()){
            if (env('USER_VERIFIED')!=1) {
                return response()->json(['errors' => ['Disabled for demo !']]);
            }
            return $this->inactiveData(Product::find($request->id));
        }
    }

    public function bulkAction(Request $request)
    {
        if ($request->ajax()) {
            if (env('USER_VERIFIED')!=1) {
                return response()->json(['errors' => ['Disabled for demo !']]);
            }
            return $this->bulkActionData($request->action_type, Product::whereIn('id',$request->idsArray));
        }
    }

    protected function imageStoreProduct($image)
    {
        $directory_large  ='/images/products/large/';
        $directory_medium  ='/images/products/medium/';
        $directory_small  ='/images/products/small/';
        $image_name        = Str::random(10). '.' .$image->getClientOriginalExtension();

        Image::make($image)->fit(720,660)->save(public_path($directory_large.$image_name));
        Image::make($image)->fit(400,400)->save(public_path($directory_medium.$image_name));
        Image::make($image)->fit(100,100)->save(public_path($directory_small.$image_name));

        return $image_name;
    }



    /*
    |--------------------------------------------------------------------------
    | Product Delete
    |--------------------------------------------------------------------------
    |
    |
    */

    public function delete($id)
    {
        // return Product::withTrashed()->find(37)->restore();
        // $onlySoftDeleted = Model::onlyTrashed()->get();

        $product = Product::find($id);
        $this->deleteWithFile($product);

        $product_images = ProductImage::where('product_id',$id);
        $this->deleteMultipleDataWithImages($product_images);

        session()->flash('type','success');
        session()->flash('message','Data Deleted Successfully.');

        return redirect()->back();
    }
}
