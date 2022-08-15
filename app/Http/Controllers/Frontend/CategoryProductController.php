<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Traits\ProductPromoBadgeTextTrait;
use Illuminate\Support\Facades\Cache;

class CategoryProductController extends Controller
{
    use ProductPromoBadgeTextTrait;


    public function categoryWiseProducts($slug)
    {
        $setting = Cache::remember('setting', 300, function () {
            return Setting::where('key','storefront_footer_tag_id')->first();
        });

        $footer_tag_ids = json_decode($setting->plain_value);

        $tags = Cache::remember('tags', 300, function () use ($footer_tag_ids) {
            return Tag::with('tagTranslations','tagTranslationEnglish')
                    ->whereIn('id',$footer_tag_ids)
                    ->where('is_active',1)
                    ->orderBy('is_active','DESC')
                    ->orderBy('id','DESC')
                    ->get();
        });

        $locale  = Session::get('currentLocal');


        $category = Category::with('catTranslation','categoryTranslationDefaultEnglish',
                'categoryProduct.product.productTranslation',
                'categoryProduct.product.productTranslationEnglish',
                'categoryProduct.product.baseImage',
                'categoryProduct.product.additionalImage',
                'child.catTranslation','child.categoryTranslationDefaultEnglish')
                ->where('slug',$slug)
                ->first();


        $product_count =0;
        if ($category->categoryProduct) {
            foreach ($category->categoryProduct as $item) {
                if ($item->product) {
                    $product_count++;
                }
            }
        }

        $attribute_values = Cache::remember('attribute_values', 300, function () use ($locale, $category) {
            return DB::table('attribute_category')
                    ->join('attribute_translations', function ($join) use ($locale) {
                        $join->on('attribute_translations.attribute_id', '=', 'attribute_category.attribute_id')
                        ->where('attribute_translations.locale', '=', $locale);
                    })
                    ->join('attribute_value_translations', function ($join) use ($locale) {
                        $join->on('attribute_value_translations.attribute_id', '=', 'attribute_category.attribute_id')
                        ->where('attribute_value_translations.local', '=', $locale);
                    })
                    ->where('category_id',$category->id)
                    ->select('attribute_category.*','attribute_translations.attribute_name','attribute_value_translations.attribute_value_id','attribute_value_translations.value_name AS attribute_value_name')
                    ->get();
        });

        return view('frontend.pages.category_wise_products',compact('category','attribute_values','product_count'));
    }

    public function categoryProductsFilterByAttributeValue(Request $request)
    {
        if(!Session::get('currentLocal')){
            Session::put('currentLocal', 'en');
            $locale = 'en';
        }else {
            $locale = Session::get('currentLocal');
        }
        App::setLocale($locale);

        $value_ids = array();
        $value_ids = explode(",",$request->attribute_value_ids);

        if (empty($request->attribute_value_ids)) {
            return response()->json(['type'=>'error']);
        }



        $category = Category::with('catTranslation','categoryTranslationDefaultEnglish','categoryProduct.product','categoryProduct.productTranslation','categoryProduct.productTranslationDefaultEnglish',
                            'categoryProduct.productBaseImage','categoryProduct.additionalImage','child.catTranslation','child.categoryTranslationDefaultEnglish')
                    ->where('slug',$request->category_slug)
                    ->first();

        $products =  DB::table('products')
                ->join('product_translations', function ($join) use ($locale) {
                    $join->on('product_translations.product_id', '=', 'products.id')
                    ->where('product_translations.local', '=', $locale);
                })
                ->join('category_product', function ($join) use ($category) {
                    $join->on('category_product.product_id', '=', 'products.id')
                    ->where('category_product.category_id', '=', $category->id);
                })
                ->join('product_images', function ($join) {
                    $join->on('product_images.product_id', '=', 'products.id')
                    ->where('product_images.type', '=', 'base');
                })
                ->select('category_product.category_id','product_images.image','product_translations.product_name','product_translations.description','products.*')
                ->get()->toArray();

        $product_attribute_value =  DB::table('product_attribute_value')
                                    ->select('product_id','attribute_value_id')
                                    ->get()
                                    ->groupBy('product_id')
                                    ->toArray();

        for ($key=0; $key < count($products); $key++) {
            if (array_key_exists($products[$key]->id,$product_attribute_value)){
                if(count($value_ids)>1) {
                    foreach ($value_ids as $val_id) {
                        $find_match = 0;
                        foreach ($product_attribute_value[$products[$key]->id] as $p_a_v) {
                            if ($p_a_v->attribute_value_id == $val_id) {
                                $find_match = 1;
                                break;
                            }
                            else {
                                $find_match = 0;
                            }
                        }
                        if($find_match == 0) {
                            array_splice($products, $key, 1);
                            $key--;
                            break;
                        }
                    }
                }
                else {
                    $find_match = 0;
                    foreach ($product_attribute_value[$products[$key]->id] as $p_a_v) {
                        if ($p_a_v->attribute_value_id == $value_ids[0]) {
                            $find_match = 1;
                            break;
                        }
                    }
                    if($find_match == 0) {
                        array_splice($products, $key, 1);
                        $key--;
                    }
                }
            }
            else{
                array_splice($products, $key, 1);
                $key--;
            }
        }

        $html = $this->shortedProductShow($category,$products);
        return response()->json($html);
    }

    public function categoryWiseSidebarFilter(Request $request)
    {
        $locale = Session::get('currentLocal');
        //Price Related
        $CHANGE_CURRENCY_RATE = (env('USER_CHANGE_CURRENCY_RATE')!= NULL) ? env('USER_CHANGE_CURRENCY_RATE'): 1;
        $data_amount = explode(" ",$request->amount);
        $data_amount_first = explode("$",$data_amount[1]);
        $data_amount_last = explode("$",$data_amount[4]);
        $min_price =  $data_amount_first[0]/$CHANGE_CURRENCY_RATE;
        $max_price =  $data_amount_last[0]/$CHANGE_CURRENCY_RATE;

        //Weight Related
        // $data_weight = explode(" ",$request->weight);
        // $min_weight =  $data_weight[0];
        // $max_weight =  $data_weight[2];

        $category = Category::with('catTranslation','categoryTranslationDefaultEnglish','categoryProduct.product','categoryProduct.productTranslation','categoryProduct.productTranslationDefaultEnglish',
                            'categoryProduct.productBaseImage','categoryProduct.additionalImage','child.catTranslation','child.categoryTranslationDefaultEnglish')
                    ->where('slug',$request->category_slug)
                    ->first();

        $products =  DB::table('products')
                    ->join('product_translations', function ($join) use ($locale) {
                        $join->on('product_translations.product_id', '=', 'products.id')
                        ->where('product_translations.local', '=', $locale);
                    })
                    ->join('category_product', function ($join) use ($category) {
                        $join->on('category_product.product_id', '=', 'products.id')
                        ->where('category_product.category_id', '=', $category->id);
                    })
                    ->join('product_images', function ($join) {
                        $join->on('product_images.product_id', '=', 'products.id')
                        ->where('product_images.type', '=', 'base');
                    })
                    ->select('category_product.category_id','product_images.image','product_translations.product_name','product_translations.description','products.*')
                    ->whereBetween('products.price', [$min_price, $max_price])
                    // ->whereBetween('products.weight', [$min_weight, $max_weight])
                    // ->where('products.weight','!=',NULL)
                    ->get();


        //Attribute Related
        $value_ids = array();
        if ($request->attribute_value_ids) {
            $value_ids = explode(",",$request->attribute_value_ids);

            $products = $products->toArray();

            $product_attribute_value =  DB::table('product_attribute_value')
                                        ->select('product_id','attribute_value_id')
                                        ->get()
                                        ->groupBy('product_id')
                                        ->toArray();

            for ($key=0; $key < count($products); $key++) {
                if (array_key_exists($products[$key]->id,$product_attribute_value)){
                    if(count($value_ids)>1) {
                        foreach ($value_ids as $val_id) {
                            $find_match = 0;
                            foreach ($product_attribute_value[$products[$key]->id] as $p_a_v) {
                                if ($p_a_v->attribute_value_id == $val_id) {
                                    $find_match = 1;
                                    break;
                                }
                                else {
                                    $find_match = 0;
                                }
                            }
                            if($find_match == 0) {
                                array_splice($products, $key, 1);
                                $key--;
                                break;
                            }
                        }
                    }
                    else {
                        $find_match = 0;
                        foreach ($product_attribute_value[$products[$key]->id] as $p_a_v) {
                            if ($p_a_v->attribute_value_id == $value_ids[0]) {
                                $find_match = 1;
                                break;
                            }
                        }
                        if($find_match == 0) {
                            array_splice($products, $key, 1);
                            $key--;
                        }
                    }
                }
                else{
                    array_splice($products, $key, 1);
                    $key--;
                }
            }
        }
        
        $html = $this->shortedProductShow($category, $products);
        return response()->json($html);
    }

    public function limitCategoryProductShow(Request $request)
    {
        $limit = $request->limit_data;

        $category =  Category::with(['categoryProduct'=>function($query) use ($limit) {
                    $query->limit($limit);
                },'categoryProduct.categoryTranslation','categoryProduct.categoryTranslationDefaultEnglish','categoryProduct.product','categoryProduct.productTranslation','categoryProduct.productTranslationDefaultEnglish','categoryProduct.productBaseImage','categoryProduct.additionalImage'])
                ->where('slug',$request->category_slug)
                ->first();

        $CHANGE_CURRENCY_SYMBOL = env('USER_CHANGE_CURRENCY_SYMBOL');
        if ($CHANGE_CURRENCY_SYMBOL==NULL) {
            $CHANGE_CURRENCY_SYMBOL = NULL;
        }
        $CURRENCY_SYMBOL = $CHANGE_CURRENCY_SYMBOL!=NULL ? $CHANGE_CURRENCY_SYMBOL : env('DEFAULT_CURRENCY_SYMBOL');

        $html = '';

        foreach ($category->categoryProduct as $item) {
            $imageurl = url("public/".$item->productBaseImage->image);


            $html .= '<form class="addToCart" >
                        <input type="hidden" name="product_id" value="'.$item->product_id.'">
                        <input type="hidden" name="product_slug" value="'.$item->product->slug.'">
                        <input type="hidden" name="category_id" value="'.$category->id.'">
                        <input type="hidden" name="qty" value="1">
                        <input type="hidden" name="_token" value="'.csrf_token().'">';


            $html .=    '<div class="product-grid-item">
                            <div class="single-product-wrapper">
                                <div class="single-product-item">';
                                if ($item->productBaseImage!=NULL){
                        $html .= '<img src="'.$imageurl.'" alt="...">';
                                }else{
                        $html .= '<img src="'.url('public/images/empty.jpg').'" alt="...">';
                                }

                        // Product Promo Badge Text
                        $html .= $this->productPromoBadgeText($item->product->manage_stock, $item->product->qty, $item->product->in_stock, date('Y-m-d'), $item->product->new_to);



                        $html .= '<div class="product-overlay">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#id_'.$item->product->id.'"> <span class="ti-zoom-in" data-bs-toggle="tooltip" data-bs-placement="top" title="quick view"></span></a>';
                                    if(Auth::check()){
                                        $html .= '<a><span class="ti-heart add_to_wishlist" data-product_id="'.$item->id.'" data-product_slug="'.$item->slug.'" data-category_id="'.$category->id.'" data-qty="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist"></span></a>';
                                    }else {
                                        $html .= '<a><span class="ti-heart" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist"></span></a>';
                                    }
                        $html .= '</div>
                            </div>
                            <div class="product-details">
                                <a class="product-name" href="">
                                    '.$item->productTranslation->product_name.'
                                </a>
                                <div class="product-short-description">
                                        '.$item->productTranslation->description.'
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="rating-summary">
                                            <div class="rating-result" title="60%">
                                                <ul class="product-rating">';
                                                    for ($i=1; $i <=5 ; $i++){
                                                        if ($i<= round($item->product->avg_rating)){
                                                            $html .= '<li><i class="las la-star"></i></li>';
                                                        }else {
                                                            $html .= '<li><i class="lar la-star"></i></li>';
                                                        }
                                                    }
                                            $html .= '</ul>
                                            </div>
                                        </div>
                                        <div class="product-price">';
                                            if ($item->product->special_price!=NULL && $item->product->special_price>0 && $item->product->special_price < $item->product->price){
                                                $html .= '<span class="promo-price">'.$CURRENCY_SYMBOL.' '.number_format((float)$item->product->special_price * env('USER_CHANGE_CURRENCY_RATE'), env('FORMAT_NUMBER'), '.', '').'</span>';
                                                $html .= '<span class="old-price">'.$CURRENCY_SYMBOL.' '.number_format((float)$item->product->price * env('USER_CHANGE_CURRENCY_RATE'), env('FORMAT_NUMBER'), '.', '').'</span>';
                                            }else{
                                                $html .= '<span class="price">'.$CURRENCY_SYMBOL.' '.number_format((float)$item->product->price * env('USER_CHANGE_CURRENCY_RATE'), env('FORMAT_NUMBER'), '.', '').'</span>';
                                            }
                                    $html .='</div>
                                    </div>';
                                    if (($item->product->manage_stock==1 && $item->product->qty==0) || ($item->product->in_stock==0)){
                                        $html .= '<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="Disabled"><button class="btn button style2 sm" disabled><i class="las la-cart-plus"></i></button></span>';
                                    }else {
                                        $html .= '<button class="button style2 sm" type="submit" data-bs-toggle="tooltip" data-bs-placement="top"><i class="las la-cart-plus"></i></button>';
                                    }

                            $html .= '</div>
                            </div>
                            <div class="product-options">
                                <div class="product-price mt-2">';
                                if ($item->product->special_price!=NULL && $item->product->special_price>0 && $item->product->special_price < $item->product->price){
                                        $html .= '<span class="promo-price">'.$CURRENCY_SYMBOL.' '.number_format((float)$item->product->special_price, env('FORMAT_NUMBER'), '.', '').'</span>';
                                        $html .= '<span class="old-price">'.$CURRENCY_SYMBOL.' '.number_format((float)$item->product->price, env('FORMAT_NUMBER'), '.', '').'</span>';
                                }else {
                                    $html .= '<span class="price">'.$CURRENCY_SYMBOL.' '.number_format((float)$item->product->price, env('FORMAT_NUMBER'), '.', '').'</span>';
                                }
                                $html .= '</div>
                            </div>
                            </div>
                        </div>
                    </form>';
        }
        return response()->json($html);
    }

    public function categoryWiseConditionProducts(Request $request)
    {

        if(!Session::get('currentLocal')){
            Session::put('currentLocal', 'en');
            $locale = 'en';
        }else {
            $locale = Session::get('currentLocal');
        }
        App::setLocale($locale);

        $category = Category::with('catTranslation','categoryTranslationDefaultEnglish','categoryProduct.product','categoryProduct.productTranslation','categoryProduct.productTranslationDefaultEnglish',
                'categoryProduct.productBaseImage','categoryProduct.additionalImage','child.catTranslation','child.categoryTranslationDefaultEnglish')
        ->where('slug',$request->category_slug)
        ->first();


        if ($request->condition=='latest') {
            $products =  DB::table('products')
                ->join('product_translations', function ($join) use ($locale) {
                    $join->on('product_translations.product_id', '=', 'products.id')
                    ->where('product_translations.local', '=', $locale);
                })
                ->join('category_product', function ($join) use ($category) {
                    $join->on('category_product.product_id', '=', 'products.id')
                    ->where('category_product.category_id', '=', $category->id);
                })
                ->join('product_images', function ($join) {
                    $join->on('product_images.product_id', '=', 'products.id')
                    ->where('product_images.type', '=', 'base');
                })
                ->select('category_product.category_id','product_images.image','product_translations.product_name','product_translations.description','products.*')
                ->orderBy('products.id','DESC')
                ->get();
        }elseif ($request->condition=='low_to_high') {
            $products =  DB::table('products')
                ->join('product_translations', function ($join) use ($locale) {
                    $join->on('product_translations.product_id', '=', 'products.id')
                    ->where('product_translations.local', '=', $locale);
                })
                ->join('category_product', function ($join) use ($category) {
                    $join->on('category_product.product_id', '=', 'products.id')
                    ->where('category_product.category_id', '=', $category->id);
                })
                ->join('product_images', function ($join) {
                    $join->on('product_images.product_id', '=', 'products.id')
                    ->where('product_images.type', '=', 'base');
                })
                ->select('category_product.category_id','product_images.image','product_translations.product_name','product_translations.description','products.*')
                ->addSelect(DB::raw('IF(is_special=0, price, special_price ) AS current_price'))
                ->orderBy('current_price','ASC')
                ->get();
        }elseif ($request->condition=='high_to_low') {
            $products =  DB::table('products')
                ->join('product_translations', function ($join) use ($locale) {
                    $join->on('product_translations.product_id', '=', 'products.id')
                    ->where('product_translations.local', '=', $locale);
                })
                ->join('category_product', function ($join) use ($category) {
                    $join->on('category_product.product_id', '=', 'products.id')
                    ->where('category_product.category_id', '=', $category->id);
                })
                ->join('product_images', function ($join) {
                    $join->on('product_images.product_id', '=', 'products.id')
                    ->where('product_images.type', '=', 'base');
                })
                ->select('category_product.category_id','product_images.image','product_translations.product_name','product_translations.description','products.*')
                ->addSelect(DB::raw('IF(is_special=0, price, special_price ) AS current_price'))
                ->orderBy('current_price','DESC')
                ->get();
        }

        $html = $this->shortedProductShow($category,$products);
        return response()->json($html);
    }


    public function categoryWisePriceRangeProducts(Request $request)
    {

        if(!Session::get('currentLocal')){
            Session::put('currentLocal', 'en');
            $locale = 'en';
        }else {
            $locale = Session::get('currentLocal');
        }
        App::setLocale($locale);
        $CHANGE_CURRENCY_RATE = (env('USER_CHANGE_CURRENCY_RATE')!= NULL) ? env('USER_CHANGE_CURRENCY_RATE'): 1;

        $data = explode(" ",$request->amount);
        $data_amount_first = explode("$",$data[1]); //previous 0
        $data_amount_last = explode("$",$data[4]); //previous 2

        $min_price =  $data_amount_first[0]/$CHANGE_CURRENCY_RATE; //previous 1
        $max_price =  $data_amount_last[0]/$CHANGE_CURRENCY_RATE; //previous 1


        $locale = Session::get('currentLocal');

        $category = Category::with('catTranslation','categoryTranslationDefaultEnglish','categoryProduct.product','categoryProduct.productTranslation','categoryProduct.productTranslationDefaultEnglish',
                            'categoryProduct.productBaseImage','categoryProduct.additionalImage','child.catTranslation','child.categoryTranslationDefaultEnglish')
                    ->where('slug',$request->category_slug)
                    ->first();

        $products =  DB::table('products')
                ->join('product_translations', function ($join) use ($locale) {
                    $join->on('product_translations.product_id', '=', 'products.id')
                    ->where('product_translations.local', '=', $locale);
                })
                ->join('category_product', function ($join) use ($category) {
                    $join->on('category_product.product_id', '=', 'products.id')
                    ->where('category_product.category_id', '=', $category->id);
                })
                ->join('product_images', function ($join) {
                    $join->on('product_images.product_id', '=', 'products.id')
                    ->where('product_images.type', '=', 'base');
                })
                ->select('category_product.category_id','product_images.image','product_translations.product_name','product_translations.description','products.*')
                ->whereBetween('products.price', [$min_price, $max_price])
                ->get();

        $html = $this->shortedProductShow($category,$products);

        return response()->json($html);
        // return view('frontend.pages.category_wise_products',compact('category','products'));
    }


    protected function shortedProductShow($category,$products)
    {
        $CHANGE_CURRENCY_SYMBOL = env('USER_CHANGE_CURRENCY_SYMBOL');
        if ($CHANGE_CURRENCY_SYMBOL==NULL) {
            $CHANGE_CURRENCY_SYMBOL = NULL;
        }
        $CURRENCY_SYMBOL = $CHANGE_CURRENCY_SYMBOL!=NULL ? $CHANGE_CURRENCY_SYMBOL : env('DEFAULT_CURRENCY_SYMBOL');


        $html = '';
        foreach ($products as $item) {
            $imageurl = url("public/".$item->image);

            $html .= '<form class="addToCart">
                        <input type="hidden" name="product_id" value="'.$item->id.'">
                        <input type="hidden" name="product_slug" value="'.$category->slug.'">
                        <input type="hidden" name="category_id" value="'.$category->id.'">
                        <input type="hidden" name="qty" value="1">
                        <input type="hidden" name="_token" value="'.csrf_token().'">';

            $html .=    '<div class="product-grid-item">
                            <div class="single-product-wrapper">
                                <div class="single-product-item">';
                                if ($item->image!=NULL){
                        $html .= '<img src="'.$imageurl.'" alt="...">';
                                }else{
                        $html .= '<img src="'.url('public/images/empty.jpg').'" alt="...">';
                                }

                        // Product Promo Badge Text
                        $html .= $this->productPromoBadgeText($item->manage_stock, $item->qty, $item->in_stock, date('Y-m-d'), $item->new_to);

                        $html .= '<div class="product-overlay">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#id_'.$item->id.'"> <span class="ti-zoom-in" data-bs-toggle="tooltip" data-bs-placement="top" title="quick view"></span></a>';
                                    if(Auth::check()){
                                        $html .= '<a><span class="ti-heart add_to_wishlist" data-product_id="'.$item->id.'" data-product_slug="'.$item->slug.'" data-category_id="'.$category->id.'" data-qty="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist"></span></a>';
                                    }else {
                                        $html .= '<a><span class="ti-heart" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist"></span></a>';
                                    }
                        $html .='</div>
                            </div>
                            <div class="product-details">
                                <a class="product-name" href="">
                                    '.$item->product_name.'
                                </a>
                                <div class="product-short-description">
                                        '.$item->description.'
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="rating-summary">
                                            <div class="rating-result" title="60%">
                                                <ul class="product-rating">';
                                                    for ($i=1; $i <=5 ; $i++){
                                                        if ($i<= round($item->avg_rating)){
                                                            $html .= '<li><i class="las la-star"></i></li>';
                                                        }else {
                                                            $html .= '<li><i class="lar la-star"></i></li>';
                                                        }
                                                    }
                                               $html .= '</ul>
                                            </div>
                                        </div>
                                        <div class="product-price">';
                                            if ($item->special_price!=NULL && $item->special_price>0 && $item->special_price < $item->price){
                                                $html .= '<span class="promo-price">'.$CURRENCY_SYMBOL.' '.number_format((float)$item->special_price * env('USER_CHANGE_CURRENCY_RATE'), env('FORMAT_NUMBER'), '.', '').'</span>';
                                                $html .= '<span class="old-price">'.$CURRENCY_SYMBOL.' '.number_format((float)$item->price * env('USER_CHANGE_CURRENCY_RATE'), env('FORMAT_NUMBER'), '.', '').'</span>';
                                            }else{
                                                $html .= '<span class="price">'.$CURRENCY_SYMBOL.' '.number_format((float)$item->price * env('USER_CHANGE_CURRENCY_RATE'), env('FORMAT_NUMBER'), '.', '').'</span>';
                                            }
                                    $html .='</div>
                                    </div>';
                                    if (($item->manage_stock==1 && $item->qty==0) || ($item->in_stock==0)){
                                        $html .=  '<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="Disabled tooltip"><button class="btn button style2 sm" disabled><i class="las la-cart-plus"></i></button></span>';
                                    }else {
                                        $html .=  '<button class="button style2 sm" type="submit" data-bs-toggle="tooltip" data-bs-placement="top"><i class="las la-cart-plus"></i></button>';
                                    }

                                $html .= '</div>
                            </div>
                            <div class="product-options">
                                <div class="product-price mt-2">';
                                if ($item->special_price!=NULL && $item->special_price>0 && $item->special_price < $item->price){
                                        $html .= '<span class="promo-price">'.$CURRENCY_SYMBOL.' '.number_format((float)$item->special_price * env('USER_CHANGE_CURRENCY_RATE'), env('FORMAT_NUMBER'), '.', '').'</span>';
                                        $html .= '<span class="old-price">'.$CURRENCY_SYMBOL.' '.number_format((float)$item->price * env('USER_CHANGE_CURRENCY_RATE'), env('FORMAT_NUMBER'), '.', '').'</span>';
                                }else {
                                    $html .= '<span class="price">'.$CURRENCY_SYMBOL.' '.number_format((float)$item->price * env('USER_CHANGE_CURRENCY_RATE'), env('FORMAT_NUMBER'), '.', '').'</span>';
                                }

                                $html .= '</div>
                            </div>
                            </div>
                        </div>
                    </form>';
        }
        return $html;
    }
}
