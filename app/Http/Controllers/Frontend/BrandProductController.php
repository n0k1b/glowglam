<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BrandProductController extends Controller
{
    public function brands()
    {
        $brands = Cache::remember('brands', 300, function () {
            return Brand::where('is_active',1)
                    ->orderBy('id','DESC')
                    ->get();
        });

        return view('frontend.pages.brand',compact('brands'));
    }

    public function brandWiseProducts($slug)
    {
        // $str = url()->current();
        // $data = explode("/",$str);
        // return url('/');


        $locale = Session::get('currentLocal');


        $brand = $this->brandInfo($locale, $slug);
        if (!$brand) {
            $locale = 'en';
            $brand = $this->brandInfo($locale, $slug);
        }

        $product_images = ProductImage::select('product_id','image','type')->get();

        $category_product =  CategoryProduct::get();

        $products = DB::table('products')
                    ->join('product_translations', function ($join) use ($locale) {
                        $join->on('product_translations.product_id', '=', 'products.id')
                        ->where('product_translations.local', '=', $locale);
                    })
                    ->join('product_images', function ($join) {
                        $join->on('product_images.product_id', '=', 'products.id')
                        ->where('product_images.type', '=', 'base');
                    })
                    ->select('products.*','product_images.image_medium','product_images.type','product_translations.product_name','product_translations.short_description')
                    ->where('brand_id',$brand->id)
                    ->orderBy('products.id','DESC')
                    ->get();

        $category_ids = [];
        foreach ($products as $key => $item) {
            foreach ($category_product as $key => $value) {
                if ($item->id==$value->product_id) {
                    $category_ids[$item->id] = $category_product[$key];
                    break;
                }
            }
        }

        $product_attr_val = Product::with('productAttributeValues')
                    ->where('brand_id',$brand->id)
                    ->orderBy('id','DESC')
                    ->get();

        return view('frontend.pages.brand_wise_product',compact('brand','products','product_images','category_ids','product_attr_val'));
    }

    protected function brandInfo($locale,$slug){
        return DB::table('brands')
                ->join('brand_translations', function ($join) use ($locale) {
                    $join->on('brand_translations.brand_id', '=', 'brands.id')
                    ->where('brand_translations.local', '=', $locale);
                })
                ->where('slug',$slug)
                ->select('brands.id','brand_translations.brand_name')
                ->first();
    }
}
