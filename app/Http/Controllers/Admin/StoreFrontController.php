<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Product;
use App\Models\Setting;
use App\Models\SettingTranslation;
use App\Models\StorefrontImage;
use App\Models\Tag;
use App\Models\Brand;
use App\Models\Color;
use App\Models\FlashSale;
use App\Models\FooterDescription;
use App\Traits\ENVFilePutContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Traits\imageHandleTrait;

use function GuzzleHttp\json_decode;

class StoreFrontController extends Controller
{
    use imageHandleTrait, ENVFilePutContent;

    public function index()
    {
        $locale = Session::get('currentLocal');
        $colors = Color::all();

        $setting = Setting::with(['settingTranslations'=> function ($query) use ($locale){
            $query->where('locale',$locale)
            ->orWhere('locale','en')
            ->orderBy('id','DESC');
        },'settingTranslation','settingTranslationDefaultEnglish'])->get();

        $pages = Page::with(['pageTranslations'=> function ($query) use ($locale){
            $query->where('locale',$locale)
            ->orWhere('locale','en')
            ->orderBy('id','DESC');
        }])
        ->where('is_active',1)
        ->get();

        $products = Product::with('productTranslation','productTranslationEnglish')
                    ->where('is_active',1)
                    ->get();

        $menus = Menu::with(['menuTranslations'=> function ($query) use ($locale){
            $query->where('locale',$locale)
                ->orWhere('locale','en')
                ->orderBy('id','DESC');
            }])
            ->where('is_active',1)
            ->get();

        $tags = Tag::with(['tagTranslation'=> function ($query) use ($locale){
            $query->where('local',$locale)
                ->orWhere('local','en')
                ->orderBy('id','DESC');
        }])
        ->where('is_active',1)
        ->get();

        $storefront_images = StorefrontImage::select('title','type','image')->get();
        $total_storefront_images = count($storefront_images);

        $categories = Category::with(['categoryTranslation'=> function ($query) use ($locale){
            $query->where('local',$locale)
            ->orWhere('local','en')
            ->orderBy('id','DESC');
        }])
        ->where('is_active',1)
        ->get();


        $array_tags = Setting::where('key','storefront_footer_tag_id')->pluck('plain_value');
        if ($array_tags[0] == NULL) {
            $array_footer_tags = [];
        }else {
            $array_footer_tags = json_decode($array_tags[0]);
        }

        $brands = Brand::with(['brandTranslation','brandTranslationEnglish'])
        ->where('is_active',1)
        ->get();

        $array_brands = Setting::where('key','storefront_top_brands')->pluck('plain_value');
        if ($array_brands[0] == NULL) {
            $array_brands = [];
        }else {
            $array_brands = json_decode($array_brands[0]);
        }

        $flash_sales = FlashSale::with('flashSaleTranslation')->where('is_active',1)->get();

        $footer_description = FooterDescription::where('locale',$locale)->first();
        if (!$footer_description) {
            $footer_description = FooterDescription::where('locale','en')->first();
        }



        return view('admin.pages.storefront.index',compact('locale','colors','setting','pages','products','menus','storefront_images',
                        'tags','total_storefront_images','array_footer_tags','categories','brands','array_brands','flash_sales','footer_description'));

    }

    public function generalStore(Request $request)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['errors'=>['This is disabled for demo']]);
        }

        $locale = Session::get('currentLocal');

        if ($request->ajax()) {
            foreach ($request->all() as $key => $value) {
                if ($key === 'storefront_welcome_text' || $key === 'storefront_address') {
                    $setting = Setting::where('key',$key)->first();
                    SettingTranslation::UpdateOrCreate(
                        ['setting_id'=>$setting->id, 'locale' => $locale],
                        ['value' => $value]
                    );
                }
                else{
                    Setting::where('key',$key)->update(['plain_value'=>$value]);
                }
                if (!$request->storefront_shop_page_enabled) {
                    Setting::where('key','storefront_shop_page_enabled')->update(['plain_value' => 0]);
                }
                if (!$request->storefront_brand_page_enabled) {
                    Setting::where('key','storefront_brand_page_enabled')->update(['plain_value' => 0]);
                }
            }

            return response()->json(['success'=>'Data Saved Successfully']);
        }
    }

    public function menuStore(Request $request)
    {

        if ($request->ajax()) {
            $locale = Session::get('currentLocal');
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }

            foreach ($request->all() as $key => $value) {
                if ($key === 'storefront_navbar_text' || $key ==='storefront_footer_menu_title_one' || $key ==='storefront_footer_menu_title_two' || $key ==='storefront_footer_menu_title_three') {
                    $setting = Setting::where('key',$key)->first();
                    SettingTranslation::UpdateOrCreate(
                        ['setting_id'=>$setting->id, 'locale' => $locale],
                        ['value' => $value]
                    );
                }
                else{
                    Setting::where('key',$key)->update(['plain_value'=>$value]);
                }
            }

            return response()->json(['success'=>'Data Saved Successfully']);
        }
    }

    public function socialLinkStore(Request $request)
    {
        if ($request->ajax()) {
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }
            foreach ($request->all() as $key => $value) {
                Setting::where('key',$key)->update(['plain_value'=>$value]);
            }

            return response()->json(['success'=>'Data Saved Successfully']);
        }
    }

    public function featureStore(Request $request)
    {
        $locale = Session::get('currentLocal');

        if ($request->ajax()) {
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }

            foreach ($request->all() as $key => $value) {
                if (
                        $key === 'storefront_feature_1_title' || $key ==='storefront_feature_1_subtitle' ||
                        $key === 'storefront_feature_2_title' || $key ==='storefront_feature_2_subtitle' ||
                        $key === 'storefront_feature_3_title' || $key ==='storefront_feature_3_subtitle' ||
                        $key === 'storefront_feature_4_title' || $key ==='storefront_feature_4_subtitle'
                    ) {
                    $setting = Setting::where('key',$key)->first();
                    SettingTranslation::UpdateOrCreate(
                        ['setting_id'=>$setting->id, 'locale' => $locale],
                        ['value' => $value]
                    );
                }
                else if($key=='storefront_section_status'){
                    continue;
                }
                else{
                    Setting::where('key',$key)->update(['plain_value'=>$value]);
                }
            }

            if (!empty($request->storefront_section_status)) {
                Setting::where('key','storefront_section_status')->update(['plain_value'=>1]);
            }else {
                Setting::where('key','storefront_section_status')->update(['plain_value'=>0]);
            }
            return response()->json(['success'=>'Data Saved Successfully']);
        }
    }

    public function logoStore(Request $request)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['errors'=>['This is disabled for demo']]);
        }

        $validator = Validator::make($request->all(),[
            'image_favicon_logo' => 'image|max:10240|mimes:jpeg,png,jpg,gif,webp',
            'image_header_logo'  => 'image|max:10240|mimes:jpeg,png,jpg,gif,webp',
            'image_mail_logo'    => 'image|max:10240|mimes:jpeg,png,jpg,gif,webp',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }



        $directory  ='/images/storefront/logo/';

        if ($request->title_favicon_logo=="favicon_logo" && (!empty($request->image_favicon_logo))) {
            $this->previousImageDeleteFromStorefront('favicon_logo');
            StorefrontImage::updateOrCreate(
                    [ 'title' => $request->title_favicon_logo, 'type' => 'logo'],
                    [ 'image' => $this->imageStore($request->image_favicon_logo,$directory,$type='store_front')]
                );
        }

        if ($request->title_header_logo=="header_logo" && (!empty($request->image_header_logo))) {
            $this->previousImageDeleteFromStorefront('header_logo');
            StorefrontImage::updateOrCreate(
                    [ 'title' => $request->title_header_logo, 'type' => 'logo'],
                    [ 'image' => $this->imageStore($request->image_header_logo,$directory,$type='header_logo')]
                );
        }
        if ($request->title_mail_logo=="mail_logo" && (!empty($request->image_mail_logo))) {
            $this->previousImageDeleteFromStorefront('mail_logo');
            StorefrontImage::updateOrCreate(
                    [ 'title' => $request->title_mail_logo, 'type' => 'logo'],
                    [ 'image' => $this->imageStore($request->image_mail_logo,$directory,$type='store_front')]
                );
        }
        return response()->json(['success' => __('Data Saved successfully.')]);

    }

    public function topBannerStore(Request $request)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['errors'=>['This is disabled for demo']]);
        }

        $directory  ='/images/storefront/logo/';
        if ($request->title_topbar_logo=="topbar_logo" && (!empty($request->image_topbar_logo))) {
            $this->previousImageDeleteFromStorefront('topbar_logo');
            StorefrontImage::updateOrCreate(
                    [ 'title' => $request->title_topbar_logo, 'type' => 'logo'],
                    [ 'image' => $this->imageStore($request->image_topbar_logo,$directory,$type='topbar_logo')]
                );
        }

        $topbar_enabled_value = null;
        if ($request->storefront_topbar_banner_enabled) {
            $topbar_enabled_value = 1;
        }
        $this->dataWriteInENVFile('TOPBAR_BANNER_ENABLED',$topbar_enabled_value);
        return response()->json(['success' => __('Data Saved successfully.')]);

    }

    public function footerStore(Request $request)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['errors'=>['This is disabled for demo']]);
        }

        $validator = Validator::make($request->all(),[
            'storefront_payment_method_image' => 'image|max:10240|mimes:jpeg,png,jpg,gif,webp',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $locale = Session::get('currentLocal');
        $directory  ='/images/storefront/payment_method/';

        if ($request->ajax()) {
            foreach ($request->all() as $key => $value) {
                if ($key === 'storefront_copyright_text') {
                    $setting = Setting::where('key',$key)->first();
                    SettingTranslation::UpdateOrCreate(
                        ['setting_id'=>$setting->id, 'locale' => $locale],
                        ['value' => $value]
                    );
                }
                elseif ($key === 'storefront_payment_method_image') {
                    $this->previousImageDeleteFromStorefront('accepted_payment_method_image');

                    StorefrontImage::updateOrCreate(
                        [ 'title' => 'accepted_payment_method_image', 'type' => 'payment_method'],
                        [ 'image' => $this->imageStore($request->storefront_payment_method_image, $directory,$type='store_front_footer')]
                    );
                }
                else{
                    Setting::where('key',$key)->update(['plain_value'=>$value]);
                }
            }


            // FooterDescription::
            FooterDescription::updateOrCreate(
                ['locale'     => $locale],
                ['description'=> htmlspecialchars_decode($request->description), 'is_active'=> $request->is_active ?? 0 ]
            );

            return response()->json(['success'=>'Data Saved Successfully']);
        }
    }

    public function newletterStore(Request $request)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['errors'=>['This is disabled for demo']]);
        }

        $validator = Validator::make($request->all(),[
            'storefront_newsletter_image' => 'image|max:10240|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        if (request()->ajax()) {
            $directory  ='/images/storefront/newsletter/';

            if ((!empty($request->storefront_newsletter_image))) {
                $this->previousImageDeleteFromStorefront('newsletter_background_image');
                StorefrontImage::updateOrCreate(
                        [ 'title' => 'newsletter_background_image', 'type' => 'newletter'],
                        [ 'image' => $this->imageStore($request->storefront_newsletter_image, $directory,$type='newslatter')]
                    );
            }
            return response()->json(['success' => __('Data Saved successfully.')]);
        }
    }


    public function productPageStore(Request $request)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['errors'=>['This is disabled for demo']]);
        }

        $validator = Validator::make($request->all(),[
            'storefront_product_page_image' => 'image|max:10240|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $directory  ='/images/storefront/product_page/';

        if ($request->ajax()) {
            if ($request->storefront_product_page_image) {
                $this->previousImageDeleteFromStorefront('product_page_banner');

                StorefrontImage::updateOrCreate(
                        [ 'title' => 'product_page_banner', 'type' => 'product_page'],
                        [ 'image' => $this->imageStore($request->storefront_product_page_image, $directory,$type='store_front')]
                    );
            }

            if ($request->storefront_call_action_url) {
                Setting::where('key','storefront_open_new_window')->update(['plain_value'=>$request->storefront_call_action_url]);
            }

            if (!empty($request->storefront_open_new_window)) {
                Setting::where('key','storefront_open_new_window')->update(['plain_value'=>1]);
            }else {
                Setting::where('key','storefront_open_new_window')->update(['plain_value'=>0]);
            }

            return response()->json(['success'=>'Data Saved Successfully']);
        }
    }

    public function sliderBannersStore(Request $request)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['errors'=>['This is disabled for demo']]);
        }

        $locale = Session::get('currentLocal');

        $validator = Validator::make($request->all(),[
            'storefront_slider_banner_1_image' => 'image|max:10240|mimes:jpeg,png,jpg,gif,webp',
            'storefront_slider_banner_2_image' => 'image|max:10240|mimes:jpeg,png,jpg,gif,webp',
            'storefront_slider_banner_3_image' => 'image|max:10240|mimes:jpeg,png,jpg,gif,webp',
        ]);

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $directory  ='/images/storefront/slider_banners/';

        if ($request->ajax()) {

            if (!empty($request->storefront_slider_banner_1_image)) {

                $this->previousImageDeleteFromStorefront('slider_banner_1');

                StorefrontImage::updateOrCreate(
                        [ 'title' => 'slider_banner_1', 'type' => 'slider_banner'],
                        [
                            'image' => $this->imageStore($request->storefront_slider_banner_1_image, $directory,$type='slider_banner'),
                            'setting_id' => 42
                        ]
                    );
            }
            if (!empty($request->storefront_slider_banner_2_image)) {

                $this->previousImageDeleteFromStorefront('slider_banner_2');

                StorefrontImage::updateOrCreate(
                        [ 'title' => 'slider_banner_2', 'type' => 'slider_banner'],
                        [
                            'image' => $this->imageStore($request->storefront_slider_banner_2_image, $directory,$type='slider_banner'),
                            'setting_id' => 45
                        ]
                    );
            }
            if (!empty($request->storefront_slider_banner_3_image)) {

                $this->previousImageDeleteFromStorefront('slider_banner_3');

                StorefrontImage::updateOrCreate(
                        [ 'title' => 'slider_banner_3', 'type' => 'slider_banner'],
                        [
                            'image' => $this->imageStore($request->storefront_slider_banner_3_image, $directory,$type='slider_banner'),
                            'setting_id' => 127
                        ]
                    );
            }

            foreach ($request->all() as $key => $value) {
                if ($key=='storefront_slider_banner_1_image' || $key=='storefront_slider_banner_2_image' || $key=='storefront_slider_banner_3_image') {
                    continue;
                }
                elseif ($key == 'storefront_slider_banner_1_title' || $key == 'storefront_slider_banner_2_title' || $key == 'storefront_slider_banner_3_title') {
                    $setting = Setting::where('key',$key)->first();
                    SettingTranslation::UpdateOrCreate(
                        ['setting_id'=>$setting->id, 'locale' => $locale],
                        ['value' => $value]
                    );
                }
                else{
                    Setting::where('key',$key)->update(['plain_value'=>$value]);
                }
            }

            if (!$request->storefront_slider_banner_1_open_in_new_window) {
                Setting::where('key', 'storefront_slider_banner_1_open_in_new_window')->update(['plain_value' => 0]);
            }
            if ((!$request->storefront_slider_banner_2_open_in_new_window)) {
                Setting::where('key', 'storefront_slider_banner_2_open_in_new_window')->update(['plain_value' => 0]);
            }
            if ((!$request->storefront_slider_banner_3_open_in_new_window)) {
                Setting::where('key', 'storefront_slider_banner_3_open_in_new_window')->update(['plain_value' => 0]);
            }

            return response()->json(['success'=>'Data Saved Successfully']);
        }
    }


    public function oneColumnBannerStore(Request $request)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['errors'=>['This is disabled for demo']]);
        }

        $validator = Validator::make($request->all(),[
            'storefront_one_column_banner_image' => 'image|max:10240|mimes:jpeg,png,jpg,gif,webp',
        ]);

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $directory  ='/images/storefront/one_column_banner/';

        if ($request->ajax()) {
            foreach ($request->all() as $key => $value) {
                if ($key=='storefront_one_column_banner_image') {

                    $this->previousImageDeleteFromStorefront('one_column_banner_image');

                    StorefrontImage::updateOrCreate(
                        [ 'title' => 'one_column_banner_image', 'type' => 'one_column_banner'],
                        [ 'image' => $this->imageStore($request->storefront_one_column_banner_image, $directory,$type='one_column_banner')]
                    );
                }
                else {
                    Setting::where('key', $key)->update(['plain_value' => $value]);
                }

                if (!$request->storefront_one_column_banner_enabled) {
                    Setting::where('key','storefront_one_column_banner_enabled')->update(['plain_value' => 0]);
                }
                if (!$request->storefront_one_column_banner_open_in_new_window) {
                    Setting::where('key','storefront_one_column_banner_open_in_new_window')->update(['plain_value' => 0]);
                }

            }
            return response()->json(['success'=>'Data Saved Successfully']);
        }
    }

    public function twoColumnBannersStore(Request $request)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['errors'=>['This is disabled for demo']]);
        }

        $validator = Validator::make($request->all(),[
            'storefront_two_column_banner_image_1' => 'image|max:10240|mimes:jpeg,png,jpg,gif',
            'storefront_two_column_banner_image_2' => 'image|max:10240|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $directory  ='/images/storefront/two_column_banners/';

        if ($request->ajax()) {
            foreach ($request->all() as $key => $value) {
                if ($key=='storefront_two_column_banner_image_1') {

                    $this->previousImageDeleteFromStorefront('two_column_banner_image_1');

                    StorefrontImage::updateOrCreate(
                        [ 'title' => 'two_column_banner_image_1', 'type' => 'two_column_banners'],
                        [ 'image' => $this->imageStore($value, $directory,$type='two_column_banners')]
                    );
                }
                elseif ($key=='storefront_two_column_banner_image_2') {

                    $this->previousImageDeleteFromStorefront('two_column_banner_image_2');

                    StorefrontImage::updateOrCreate(
                        [ 'title' => 'two_column_banner_image_2', 'type' => 'two_column_banners'],
                        [ 'image' => $this->imageStore($value, $directory,$type='two_column_banners')]
                    );
                }
                else {
                    Setting::where('key', $key)->update(['plain_value' => $value]);
                }
            }

            if (!$request->storefront_two_column_banner_enabled) {
                Setting::where('key','storefront_two_column_banner_enabled')->update(['plain_value' => 0]);
            }
            if (!$request->storefront_two_column_banners_1_open_in_new_window) {
                Setting::where('key','storefront_two_column_banners_1_open_in_new_window')->update(['plain_value' => 0]);
            }
            if (!$request->storefront_two_column_banners_2_open_in_new_window) {
                Setting::where('key','storefront_two_column_banners_2_open_in_new_window')->update(['plain_value' => 0]);
            }

            return response()->json(['success'=>'Data Saved Successfully']);
        }
    }

    public function threeColumnBannersStore(Request $request)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['errors'=>['This is disabled for demo']]);
        }

        $validator = Validator::make($request->all(),[
            'storefront_three_column_banners_image_1' => 'image|max:10240|mimes:jpeg,png,jpg,gif',
            'storefront_three_column_banners_image_2' => 'image|max:10240|mimes:jpeg,png,jpg,gif',
            'storefront_three_column_banners_image_3' => 'image|max:10240|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $directory  ='/images/storefront/three_column_banners/';

        if ($request->ajax()) {
            foreach ($request->all() as $key => $value) {
                if ($key=='storefront_three_column_banners_image_1') {
                    $this->previousImageDeleteFromStorefront('three_column_banners_image_1');
                    StorefrontImage::updateOrCreate(
                        [ 'title' => 'three_column_banners_image_1', 'type' => 'three_column_banners'],
                        [ 'image' => $this->imageStore($value, $directory,$type='three_column_banners')]
                    );
                }
                elseif ($key=='storefront_three_column_banners_image_2') {
                    $this->previousImageDeleteFromStorefront('three_column_banners_image_2');
                    StorefrontImage::updateOrCreate(
                        [ 'title' => 'three_column_banners_image_2', 'type' => 'three_column_banners'],
                        [ 'image' => $this->imageStore($value, $directory,$type='three_column_banners')]
                    );
                }
                elseif ($key=='storefront_three_column_banners_image_3') {
                    $this->previousImageDeleteFromStorefront('three_column_banners_image_3');
                    StorefrontImage::updateOrCreate(
                        [ 'title' => 'three_column_banners_image_3', 'type' => 'three_column_banners'],
                        [ 'image' => $this->imageStore($value, $directory,$type='three_column_banners')]
                    );
                }
                else {
                    Setting::where('key', $key)->update(['plain_value' => $value]);
                }
            }


            if (!$request->storefront_three_column_banners_enabled) {
                Setting::where('key','storefront_three_column_banners_enabled')->update(['plain_value' => 0]);
            }
            if (!$request->storefront_three_column_banners_1_open_in_new_window) {
                Setting::where('key','storefront_three_column_banners_1_open_in_new_window')->update(['plain_value' => 0]);
            }
            if (!$request->storefront_three_column_banners_2_open_in_new_window) {
                Setting::where('key','storefront_three_column_banners_2_open_in_new_window')->update(['plain_value' => 0]);
            }
            if (!$request->storefront_three_column_banners_3_open_in_new_window) {
                Setting::where('key','storefront_three_column_banners_3_open_in_new_window')->update(['plain_value' => 0]);
            }

            return response()->json(['success'=>'Data Saved Successfully']);
        }
    }

    public function threeColumnFllWidthBannersStore(Request $request)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['errors'=>['This is disabled for demo']]);
        }

        $validator = Validator::make($request->all(),[
            'storefront_three_column_full_width_banners_background_image' => 'image|max:10240|mimes:jpeg,png,jpg,gif',
            'storefront_three_column_full_width_banners_image_1' => 'image|max:10240|mimes:jpeg,png,jpg,gif',
            'storefront_three_column_full_width_banners_image_2' => 'image|max:10240|mimes:jpeg,png,jpg,gif',
            'storefront_three_column_full_width_banners_image_3' => 'image|max:10240|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $directory  ='/images/storefront/three_column_full_width_banners/';


        if ($request->ajax()) {
            foreach ($request->all() as $key => $value) {
                if ($key=='storefront_three_column_full_width_banners_background_image') {
                    $this->previousImageDeleteFromStorefront('three_column_full_width_banners_background_image');
                    StorefrontImage::updateOrCreate(
                        [ 'title' => 'three_column_full_width_banners_background_image', 'type' => 'three_column_full_width_banners'],
                        [ 'image' => $this->imageStore($value, $directory,$type='three_column_full_width_banners')]
                    );
                }
                elseif ($key=='storefront_three_column_full_width_banners_image_1') {
                    $this->previousImageDeleteFromStorefront('three_column_full_width_banners_image_1');
                    StorefrontImage::updateOrCreate(
                        [ 'title' => 'three_column_full_width_banners_image_1', 'type' => 'three_column_full_width_banners'],
                        [ 'image' => $this->imageStore($value, $directory,$type='three_column_full_width_banners')]
                    );
                }
                elseif ($key=='storefront_three_column_full_width_banners_image_2') {
                    $this->previousImageDeleteFromStorefront('three_column_full_width_banners_image_2');
                    StorefrontImage::updateOrCreate(
                        [ 'title' => 'three_column_full_width_banners_image_2', 'type' => 'three_column_full_width_banners'],
                        [ 'image' => $this->imageStore($value, $directory,$type='three_column_full_width_banners')]
                    );
                }
                elseif ($key=='storefront_three_column_full_width_banners_image_3') {
                    $this->previousImageDeleteFromStorefront('three_column_full_width_banners_image_3');
                    StorefrontImage::updateOrCreate(
                        [ 'title' => 'three_column_full_width_banners_image_3', 'type' => 'three_column_full_width_banners'],
                        [ 'image' => $this->imageStore($value, $directory,$type='three_column_full_width_banners')]
                    );
                }
                else {
                    Setting::where('key', $key)->update(['plain_value' => $value]);
                }
            }


            if (!$request->storefront_three_column_full_width_banners_enabled) {
                Setting::where('key','storefront_three_column_full_width_banners_enabled')->update(['plain_value' => 0]);
            }
            if (!$request->storefront_three_column_full_width_banners_1_open_in_new_window) {
                Setting::where('key','storefront_three_column_full_width_banners_1_open_in_new_window')->update(['plain_value' => 0]);
            }
            if (!$request->storefront_three_column_full_width_banners_2_open_in_new_window) {
                Setting::where('key','storefront_three_column_full_width_banners_2_open_in_new_window')->update(['plain_value' => 0]);
            }
            if (!$request->storefront_three_column_full_width_banners_3_open_in_new_window) {
                Setting::where('key','storefront_three_column_full_width_banners_3_open_in_new_window')->update(['plain_value' => 0]);
            }

            return response()->json(['success'=>'Data Saved Successfully']);
        }
    }

    public function topBrandsStore(Request $request)
    {
        if ($request->ajax()) {

            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }

            if($request->storefront_top_brands_section_enabled){
                Setting::where('key','storefront_top_brands_section_enabled')->update(['plain_value'=>1]);
            }else{
                Setting::where('key','storefront_top_brands_section_enabled')->update(['plain_value'=>0]);
            }

            if($request->storefront_top_brands){
                Setting::where('key','storefront_top_brands')->update(['plain_value'=>json_encode($request->storefront_top_brands)]);
            }

            return response()->json(['success'=>'Data Saved Successfully']);
        }
    }

    public function topCategoriesStore(Request $request)
    {
        if ($request->ajax()) {
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }
            if($request->storefront_top_categories_section_enabled){
                Setting::where('key','storefront_top_categories_section_enabled')->update(['plain_value'=>1]);
            }else{
                Setting::where('key','storefront_top_categories_section_enabled')->update(['plain_value'=>0]);
            }

            return response()->json(['success'=>'Data Saved Successfully']);
        }
    }

    public function productTabsOneStore(Request $request)
    {
        if ($request->ajax()) {

            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }

            if(empty($request->storefront_product_tabs_1_section_enabled)){
                Setting::where('key','storefront_product_tabs_1_section_enabled')->update(['plain_value'=>0]);
            }

            $locale = Session::get('currentLocal');

            foreach ($request->all() as $key => $value) {
                if ($key == 'storefront_product_tabs_1_section_tab_1_title'|| $key =='storefront_product_tabs_1_section_tab_2_title' || $key =='storefront_product_tabs_1_section_tab_3_title' || $key=='storefront_product_tabs_1_section_tab_4_title') {
                    $setting = Setting::where('key',$key)->first();
                    SettingTranslation::UpdateOrCreate(
                        ['setting_id'=>$setting->id, 'locale' => $locale],
                        ['value' => $value]
                    );
                }
                else{
                    Setting::where('key',$key)->update(['plain_value'=>$value]);
                }
            }
            return response()->json(['success'=>'Data Saved Successfully']);
        }

    }

    public function productTabsTwoStore(Request $request)
    {
        if ($request->ajax()) {
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }

            if(empty($request->storefront_product_tabs_2_section_enabled)){
                Setting::where('key','storefront_product_tabs_2_section_enabled')->update(['plain_value'=>0]);
            }

            $locale = Session::get('currentLocal');

            foreach ($request->all() as $key => $value) {
                if ($key == 'storefront_product_tabs_2_section_title' || $key == 'storefront_product_tabs_2_section_tab_1_title'|| $key =='storefront_product_tabs_2_section_tab_2_title' || $key =='storefront_product_tabs_2_section_tab_3_title' || $key=='storefront_product_tabs_2_section_tab_4_title') {
                    $setting = Setting::where('key',$key)->first();
                    SettingTranslation::UpdateOrCreate(
                        ['setting_id'=>$setting->id, 'locale' => $locale],
                        ['value' => $value]
                    );
                }
                else{
                    Setting::where('key',$key)->update(['plain_value'=>$value]);
                }
            }
            return response()->json(['success'=>'Data Saved Successfully']);
        }
    }


    public function flashSaleAndVerticalProductsStore(Request $request)
    {
        if ($request->ajax()) {
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }

            if(empty($request->storefront_flash_sale_and_vertical_products_section_enabled)){
                Setting::where('key','storefront_product_tabs_1_section_enabled')->update(['plain_value'=>0]);
            }

            $locale = Session::get('currentLocal');
            foreach ($request->all() as $key => $value) {
                if ($key == 'storefront_flash_sale_title'|| $key =='storefront_vertical_product_1_title' || $key =='storefront_vertical_product_2_title' || $key=='storefront_vertical_product_3_title') {
                    $setting = Setting::where('key',$key)->first();
                    SettingTranslation::UpdateOrCreate(
                        ['setting_id'=>$setting->id, 'locale' => $locale],
                        ['value' => $value]
                    );
                }
                else{
                    Setting::where('key',$key)->update(['plain_value'=>$value]);
                }
            }
            return response()->json(['success'=>'Data Saved Successfully']);
        }
    }

    //previous Image Delete when Update
    protected function previousImageDeleteFromStorefront($title)
    {
        $storefrontImage = StorefrontImage::where('title',$title);
        if ($storefrontImage->exists()) {
            $this->previousImageDelete($storefrontImage->first()->image);
        }
        return;
    }


    protected function color()
    {
        $colors = array(
            array(
                'color_name' => 'Blue',
                'color_code' => '#0071df',
            ),
            array(
                'color_name' => 'Black',
                'color_code' => '#000000',
            ),
            array(
                'color_name' => 'Red',
                'color_code' => '#FF0000',
            ),
            array(
                'color_name' => 'Yellow',
                'color_code' => '#FFFF00',
            ),
            array(
                'color_name' => 'Green',
                'color_code' => '#00FF00',
            ),
            array(
                'color_name' => 'Orange',
                'color_code' => '#FFA500',
            ),
            array(
                'color_name' => 'Pink',
                'color_code' => '#FFC0CB',
            ),
        );

        return $colors;
    }
}

