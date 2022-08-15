<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Country;
use App\Models\CurrencyRate;
use App\Models\SettingAboutUs;
use App\Models\SettingAboutUsTranslation;
use App\Models\SettingBankTransfer;
use App\Models\SettingCashOnDelivery;
use App\Models\SettingCheckMoneyOrder;
use App\Models\SettingCurrency;
use App\Models\SettingCustomCssJss;
use App\Models\SettingFacebook;
use App\Models\SettingFlatRate;
use App\Models\SettingFreeShipping;
use App\Models\SettingGeneral;
use App\Models\SettingGoogle;
use App\Models\SettingLocalPickup;
use App\Models\SettingMail;
use App\Models\SettingNewsletter;
use App\Models\SettingPaypal;
use App\Models\SettingPaytm;
use App\Models\SettingSms;
use App\Models\SettingStore;
use App\Models\SettingStrip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Traits\ENVFilePutContent;
use App\Traits\imageHandleTrait;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    use ENVFilePutContent, imageHandleTrait;

    public function index()
    {
        $zones_array = array();
		$timestamp   = time();

        foreach (timezone_identifiers_list() as $key => $zone){
            date_default_timezone_set($zone);
            $zones_array[$key]['zone'] = $zone;
            $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
        }

        $countries = Country::all();

        $setting_general = SettingGeneral::latest()->first();
        if (!empty($setting_general)) {
            $selected_countries = array();
            $selected_countries = explode(",",$setting_general->supported_countries);
        }else{
            $setting_general = [];
            $selected_countries = [];
        }


        // $setting_store = SettingStore::latest()->first();
        // if (empty($setting_store)) {
        //     $setting_store = [];
        // }

        //---- Store-Contact ---
        $schedules = [];
        $data = null;
        $setting_store = SettingStore::latest()->first();
        if (!empty($setting_store)) {
            $data = json_decode($setting_store->schedule);
            if ($data) {
                foreach ($data as $key => $value) {
                    $schedules[] = $value;
                }
            }
        }


        //Currency
        $currencies = Currency::all();

        $setting_currency = SettingCurrency::latest()->first();

        if (!empty($setting_currency)) {
            $selected_currencies = array();
            $selected_currencies= explode(",",$setting_currency->supported_currency);
        }else{
            $setting_currency = [];
            $selected_currencies= [];
        }

        $setting_sms = SettingSms::latest()->first();
        if (empty($setting_sms)) {
            $setting_sms = [];
        }

        $setting_mail = SettingMail::latest()->first();
        if (empty($setting_mail)) {
            $setting_mail = [];
        }

        $setting_newsletter = SettingNewsletter::latest()->first();
        if (empty($setting_newsletter)) {
            $setting_newsletter = [];
        }

        $setting_custom_css_js = SettingCustomCssJss::latest()->first();
        if (empty($setting_custom_css_js)) {
            $setting_custom_css_js = [];
        }

        $setting_facebook = SettingFacebook::latest()->first();
        if (empty($setting_facebook)) {
            $setting_facebook = [];
        }

        $setting_google = SettingGoogle::latest()->first();
        if (empty($setting_google)) {
            $setting_google = [];
        }

        $setting_free_shipping = SettingFreeShipping::latest()->first();
        $setting_local_pickup  = SettingLocalPickup::latest()->first();
        $setting_flat_rate  = SettingFlatRate::latest()->first();
        $setting_paypal  = SettingPaypal::latest()->first();
        $setting_strip  = SettingStrip::latest()->first();
        $setting_paytm  = SettingPaytm::latest()->first();
        $setting_cash_on_delivery  = SettingCashOnDelivery::latest()->first();
        $setting_bank_transfer  = SettingBankTransfer::latest()->first();
        $setting_check_money_order  = SettingCheckMoneyOrder::latest()->first();

        $setting_about_us = SettingAboutUs::with('aboutUsTranslation','aboutUsTranslationEnglish')->latest()->first();


        return view('admin.pages.setting.index',compact('countries','currencies','zones_array','setting_general','selected_countries','setting_store','selected_currencies',
                    'setting_currency','setting_sms','setting_mail','setting_newsletter','setting_custom_css_js','setting_facebook','setting_google',
                    'setting_free_shipping','setting_local_pickup','setting_flat_rate','setting_paypal','setting_strip','setting_paytm',
                    'setting_cash_on_delivery','setting_bank_transfer','setting_check_money_order','schedules','setting_about_us'));
    }

    public function generalStoreOrUpdate(Request $request)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['errors'=>['This is disabled for demo']]);
        }

        $validator = Validator::make($request->only('supported_countries','default_country','default_timezone','customer_role'),[
            'supported_countries' => 'required',
            'default_country'     => 'required',
            'default_timezone'    => 'required',
            'customer_role'       => 'required'
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }


        $data = [];
        $data['supported_countries'] = implode(",", $request->supported_countries);
        $data['default_country']     = $request->default_country;
        $data['default_timezone']    = $request->default_timezone;
        $data['customer_role']       = $request->customer_role;
        $data['number_format_type']  = $request->number_format_type;
        $data['reviews_and_ratings'] = $request->reviews_and_ratings;
        $data['auto_approve_reviews']= $request->auto_approve_reviews;
        $data['cookie_bar']          = $request->cookie_bar;

        $setting_general = SettingGeneral::latest()->first();

        if (empty($setting_general)) {
            SettingGeneral::create($data);
        }else {
            SettingGeneral::whereId($setting_general->id)->update($data);
        }


        //Manual
        $path = '.env';
        $searchArray = array('FORMAT_NUMBER=' . env('FORMAT_NUMBER'));
		$replaceArray= array('FORMAT_NUMBER=' . $request->number_format_type);
		file_put_contents($path, str_replace($searchArray, $replaceArray, file_get_contents($path)));


        $this->dataWriteInENVFile('APP_TIMEZONE',$request->default_timezone);

        return response()->json(['success' => __('Data Added successfully.')]);
    }

    public function storeStoreOrUpdate(Request $request)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['errors'=>['This is disabled for demo']]);
        }

        $validator = Validator::make($request->only('store_name','store_email','store_phone','admin_logo'),[
            'store_name' => 'required',
            'store_email'=> 'required',
            'store_phone'=> 'required',
            'admin_logo' => 'image|max:10240|mimes:jpeg,png,jpg,gif,webp',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $data = [];
        $data['store_name']    = $request->store_name;
        $data['store_tagline'] = $request->store_tagline;
        $data['store_email'] = $request->store_email;
        $data['store_phone']   = $request->store_phone;
        $data['store_address_1'] = $request->store_address_1;
        $data['store_address_2'] = $request->store_address_2;
        $data['store_city']    = $request->store_city;
        $data['store_country'] = $request->store_country;
        $data['store_state']   = $request->store_state;
        $data['store_zip']     = $request->store_zip;
        $data['hide_store_phone'] = $request->hide_store_phone;
        $data['hide_store_email'] = $request->hide_store_email;
        $data['get_in_touch'] = $request->get_in_touch;
        $data['schedule'] =  $request->schedule;

        $admin_logo   = $request->file('admin_logo');

        $setting_store = SettingStore::latest()->first();
        if ($setting_store) {
            if ($admin_logo) {
                $this->previousImageDelete($setting_store->admin_logo); //previous image will be deleted
                $data['admin_logo'] = $this->imageStore($admin_logo, $directory='images/general/',$type='general');
            }
            SettingStore::whereId($setting_store->id)->update($data);
        }else {
            $data['admin_logo'] = $this->imageStore($admin_logo, $directory='images/general/',$type='general');
            SettingStore::create($data);
        }

        return response()->json(['success' => __('Data Added successfully.')]);
    }

    public function aboutUsStoreOrUpdate(Request $request)
    {
        if ($request->ajax()) {
            $about_us = SettingAboutUs::latest()->first();
            if (!$about_us) {
                $setting_about = SettingAboutUs::create([
                    'status'=>$request->input('status',0),
                    'image'=> $this->imageStore($request->image, $directory='images/about_us/', $type='about_us'),
                ]);
                SettingAboutUsTranslation::create([
                    'setting_about_us_id' => $setting_about->id,
                    'locale' => Session::get('currentLocal'),
                    'title' => $request->title,
                    'description' => $request->description,
                ]);

            }else {

                $setting_about = SettingAboutUs::find($about_us->id);
                $setting_about->status = $request->input('status',0);
                if($request->image){
                    $setting_about->image = $this->imageStore($request->image, $directory='images/about_us/', $type='about_us');
                }
                $setting_about->update();

                SettingAboutUsTranslation::updateOrCreate(
                    [
                        'setting_about_us_id' => $setting_about->id,
                        'locale' => Session::get('currentLocal'),
                    ],
                    [
                        'title' => $request->title,
                        'description' => $request->description,
                    ]
                );
            }
        }
        return response()->json(['success' => __('Data Added successfully.')]);
    }

    public function currencyStoreOrUpdate(Request $request)
    {
        if ($request->ajax()) {

            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }

            $validator = Validator::make($request->only('default_currency','currency_format','default_currency_code'),[
                'default_currency' => 'required',
                'default_currency_code' => 'required',
                'currency_format'=> 'required',
            ]);

            if ($validator->fails()){
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $default_currency_code = $request->default_currency_code;
            $selected_currencies = Currency::whereIn('currency_name',$request->supported_currencies)->select('currency_name','currency_code')->get();

            $match = 0;
            foreach ($selected_currencies as $value) {
                if ($default_currency_code==$value->currency_code) {
                    $match =1;
                }
            }

            if ($match == 0) {
                return response()->json(['selectionError' => 'You must set Default Currency value in Supported Currency']);
            }


            if ($request->exchange_rate_service=="fixer" && $request->fixer_access_key==NULL) {
                return response()->json(['error_exchange_rate_service' => "Please Input Fixer Access Key"]);
            }
            elseif ($request->exchange_rate_service=="forge" && $request->forge_api_key==NULL) {
                return response()->json(['error_exchange_rate_service' => "Please Input Forge Api Key"]);
            }
            elseif ($request->exchange_rate_service=="currency_data_feed" && $request->currency_data_feed_key==NULL) {
                return response()->json(['error_exchange_rate_service' => "Please Input Currency Data Feed Key"]);
            }


            $data = [];
            $data['supported_currency'] = implode(",", $request->supported_currencies);
            $data['default_currency_code']    = $default_currency_code;
            $data['default_currency']    = $request->default_currency;
            $data['currency_format'] = $request->currency_format;
            $data['exchange_rate_service'] = $request->exchange_rate_service;
            $data['fixer_access_key']   = $request->fixer_access_key;
            $data['forge_api_key'] = $request->forge_api_key;
            $data['currency_data_feed_key'] = $request->currency_data_feed_key;
            $data['auto_refresh']    = $request->auto_refresh;

            $setting_currency = SettingCurrency::latest()->first();

            if (empty($setting_currency)) {
                SettingCurrency::create($data);
            }else {
                SettingCurrency::whereId($setting_currency->id)->update($data);
            }

            CurrencyRate::whereNotIn('currency_name',$request->supported_currencies)->delete();
            foreach ($selected_currencies as $value) {
                CurrencyRate::updateOrCreate(
                    [ 'currency_name' => $value->currency_name],
                    [ 'currency_code' => $value->currency_code]
                );
            }


            //Default Currency
            $this->dataWriteInENVFile('DEFAULT_CURRENCY_CODE',$request->default_currency_code);
            $this->dataWriteInENVFile('DEFAULT_CURRENCY_SYMBOL',$request->default_currency);
            $this->dataWriteInENVFile('CURRENCY_FORMAT',$request->currency_format);

            return response()->json(['success' => __('Data added Successfully')]);
        }
    }

    public function smsStoreOrUpdate(Request $request)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['errors'=>['This is disabled for demo']]);
        }

        $validator = Validator::make($request->only('sms_from'),[
            'sms_from' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        if ($request->sms_service=="vonage" && $request->api_key==NULL && $request->api_secret==NULL) {
            return response()->json(['error_sms_service' => "The API Key and API Secret Fields are required"]);
        }
        else if ($request->sms_service=="vonage" && $request->api_key==NULL) {
            return response()->json(['error_sms_service' => "The API Key Field is required"]);
        }
        elseif ($request->sms_service=="vonage" && $request->api_secret==NULL) {
            return response()->json(['error_sms_service' => "The API Secret Field is required"]);
        }
        if ($request->sms_service=="twilio" && $request->account_sid==NULL && $request->auth_token==NULL) {
            return response()->json(['error_sms_service' => "The Account SID and Auth Token fields are required"]);
        }
        else if ($request->sms_service=="twilio" && $request->account_sid==NULL) {
            return response()->json(['error_sms_service' => "The Account SID Field is required"]);
        }
        elseif ($request->sms_service=="twilio" && $request->auth_token==NULL) {
            return response()->json(['error_sms_service' => "The Auth Token field is required"]);
        }


        $data = [];
        $data['sms_from']    = $request->sms_from;
        $data['sms_service'] = $request->sms_service;
        $data['api_key']     = $request->api_key;
        $data['api_secret']  = $request->api_secret;
        $data['account_sid'] = $request->account_sid;
        $data['auth_token']  = $request->auth_token;
        $data['welcome_sms'] = $request->welcome_sms;
        $data['new_order_sms_to_admin'] = $request->new_order_sms_to_admin;
        $data['new_order_sms_to_customer'] = $request->new_order_sms_to_customer;
        $data['sms_order_status'] = $request->sms_order_status;


        $setting_sms = SettingSms::latest()->first();

        if (empty($setting_sms)) {
            SettingSms::create($data);
        }else {
            SettingSms::whereId($setting_sms->id)->update($data);
        }
        return response()->json(['success' => __('Data Added successfully.')]);
    }

    public function mailStoreOrUpdate(Request $request)
    {
        if ($request->ajax()) {

            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }

            $data = [];
            $data['mail_address']  = $request->mail_address;
            $data['mail_name']     = $request->mail_name;
            $data['mail_host']     = $request->mail_host;
            $data['mail_port']     = $request->mail_port;
            $data['mail_username'] = $request->mail_username;
            if ($request->mail_password) {
                $data['mail_password']  = Hash::make($request->mail_password);
            }
            $data['mail_encryption']= $request->mail_encryption;
            $data['welcome_email'] = $request->welcome_email;
            $data['new_order_to_admin'] = $request->new_order_to_admin;
            $data['invoice_mail']  = $request->invoice_mail;
            $data['mail_order_status'] = $request->mail_order_status;

            $setting_mail = SettingMail::latest()->first();

            if (empty($setting_mail)) {
                SettingMail::create($data);
            }else {
                SettingMail::whereId($setting_mail->id)->update($data);
            }

            $this->dataWriteInENVFile('MAIL_HOST',$data['mail_host']);
            $this->dataWriteInENVFile('MAIL_PORT',$data['mail_port']);
            $this->dataWriteInENVFile('MAIL_USERNAME',$data['mail_username']);
            $this->dataWriteInENVFile('MAIL_PASSWORD',$data['mail_password']);
            $this->dataWriteInENVFile('MAIL_ENCRYPTION',$data['mail_encryption']);
            $this->dataWriteInENVFile('MAIL_FROM_ADDRESS',$data['mail_address']);
            $this->dataWriteInENVFile('MAIL_FROM_NAME',$data['mail_name']);

            return response()->json(['success' => __('Data Added successfully.')]);
        }
    }

    public function newsletterStoreOrUpdate(Request $request)
    {
        if ($request->ajax()) {

            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }

            $data = [];
            $data['newsletter']        = $request->newsletter;
            $data['mailchimp_api_key'] = $request->mailchimp_api_key;
            $data['mailchimp_list_id'] = $request->mailchimp_list_id;

            $setting_newsletter = SettingNewsletter::latest()->first();

            if (empty($setting_newsletter)) {
                SettingNewsletter::create($data);
            }else {
                SettingNewsletter::whereId($setting_newsletter->id)->update($data);
            }

            $newslatter_popup_enabled = null;
            if ($request->storefront_newslatter_popup_enabled) {
                $newslatter_popup_enabled = 1;
            }
            $this->dataWriteInENVFile('NEWSLATTER_POPUP_ENABLED',$newslatter_popup_enabled);

            $this->dataWriteInENVFile('MAILCHIMP_APIKEY',$request->mailchimp_api_key);
            $this->dataWriteInENVFile('MAILCHIMP_LIST_ID',$request->mailchimp_list_id);


            return response()->json(['success' => __('Data Added successfully.')]);
        }
    }

    public function customCssJsStoreOrUpdate(Request $request)
    {
        if ($request->ajax()) {

            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }

            $data = [];
            $data['header'] = $request->header;
            $data['footer'] = $request->footer;

            $setting_custom_css_js = SettingCustomCssJss::latest()->first();

            if (empty($setting_custom_css_js)) {
                SettingCustomCssJss::create($data);
            }else {
                SettingCustomCssJss::whereId($setting_custom_css_js->id)->update($data);
            }
            return response()->json(['success' => __('Data Added successfully.')]);
        }
    }

    public function facebookStoreOrUpdate(Request $request)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['errors'=>['This is disabled for demo']]);
        }

        $validator = Validator::make($request->only('app_id','app_secret'),[
            'app_id' => 'required',
            'app_secret' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        if ($request->ajax()) {
            $data = [];
            $data['status'] = $request->status;
            $data['app_id'] = $request->app_id;
            $data['app_secret'] = $request->app_secret;

            $setting_facebook = SettingFacebook::latest()->first();

            if (empty($setting_facebook)) {
                SettingFacebook::create($data);
            }else {
                SettingFacebook::whereId($setting_facebook->id)->update($data);
            }

            $this->dataWriteInENVFile('FACEBOOK_CLIENT_ID',$request->app_id);
            $this->dataWriteInENVFile('FACEBOOK_CLIENT_SECRET',$request->app_secret);

            return response()->json(['success' => __('Data Added successfully.')]);
        }
    }

    public function googleStoreOrUpdate(Request $request)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['errors'=>['This is disabled for demo']]);
        }

        $validator = Validator::make($request->only('client_id','client_secret'),[
            'client_id' => 'required',
            'client_secret' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        if ($request->ajax()) {
            $data = [];
            $data['status'] = $request->status;
            $data['client_id'] = $request->client_id;
            $data['client_secret'] = $request->client_secret;

            $setting_google = SettingGoogle::latest()->first();

            if (empty($setting_google)) {
                SettingGoogle::create($data);
            }else {
                SettingGoogle::whereId($setting_google->id)->update($data);
            }

            $this->dataWriteInENVFile('GOOGLE_CLIENT_ID','"'.$request->client_id.'"');
            $this->dataWriteInENVFile('GOOGLE_CLIENT_SECRET','"'.$request->client_secret.'"');

            return response()->json(['success' => __('Data Added successfully.')]);
        }
    }

    public function githubStoreOrUpdate(Request $request)
    {
        if ($request->ajax()) {

            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }

            $this->dataWriteInENVFile('GITHUB_CLIENT_ID',$request->github_client_id);
            $this->dataWriteInENVFile('GITHUB_CLIENT_SECRET',$request->github_client_secret);

            return response()->json(['success' => __('Data Added successfully.')]);
        }
    }


    public function freeShippingStoreOrUpdate(Request $request)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['errors'=>['This is disabled for demo']]);
        }

        $validator = Validator::make($request->only('label'),[
            'label' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        if ($request->ajax()) {
            $data = [];
            $data['shipping_status'] = $request->shipping_status;
            $data['label'] = $request->label;
            $data['minimum_amount'] = $request->minimum_amount;

            $setting_free_shipping = SettingFreeShipping::latest()->first();

            if (empty($setting_free_shipping)) {
                SettingFreeShipping::create($data);
            }else {
                SettingFreeShipping::whereId($setting_free_shipping->id)->update($data);
            }
            return response()->json(['success' => __('Data Added successfully.')]);
        }
    }

    public function localPickupStoreOrUpdate(Request $request)
    {

        if (!env('USER_VERIFIED')) {
            return response()->json(['errors'=>['This is disabled for demo']]);
        }


        $validator = Validator::make($request->only('label','cost'),[
            'label' => 'required',
            'cost' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        if ($request->ajax()) {
            $data = [];
            $data['pickup_status'] = $request->pickup_status;
            $data['label'] = $request->label;
            $data['cost'] = $request->cost;

            $setting_local_pickup = SettingLocalPickup::latest()->first();

            if (empty($setting_local_pickup)) {
                SettingLocalPickup::create($data);
            }else {
                SettingLocalPickup::whereId($setting_local_pickup->id)->update($data);
            }
            return response()->json(['success' => __('Data Added successfully.')]);
        }
    }

    public function flatRateStoreOrUpdate(Request $request)
    {
        if ($request->ajax()) {

            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }

            $validator = Validator::make($request->only('label','cost'),[
                'label' => 'required',
                'cost' => 'required',
            ]);

            if ($validator->fails()){
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            if ($request->ajax()) {
                $data = [];
                $data['flat_status'] = $request->flat_status;
                $data['label'] = $request->label;
                $data['cost'] = $request->cost;

                $setting_flat_rate = SettingFlatRate::latest()->first();

                if (empty($setting_flat_rate)) {
                    SettingFlatRate::create($data);
                }else {
                    SettingFlatRate::whereId($setting_flat_rate->id)->update($data);
                }
                return response()->json(['success' => __('Data Added successfully.')]);
            }
        }
    }

    public function paypalStoreOrUpdate(Request $request)
    {
        if ($request->ajax()) {

            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }

            $validator = Validator::make($request->only('label','description','client_id','secret'),[
                'label' => 'required',
                'description' => 'required',
                'client_id' => 'required',
                'secret' => 'required',
            ]);

            if ($validator->fails()){
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $data = [];
            $data['status'] = $request->status;
            $data['label'] = $request->label;
            $data['description'] = $request->description;
            $data['sandbox'] = $request->sandbox;
            $data['client_id'] = $request->client_id;
            $data['secret'] = $request->secret;

            $setting_paypal = SettingPaypal::latest()->first();

            $this->dataWriteInENVFile('PAYPAL_SANDBOX_CLIENT_ID',$request->client_id);
            $this->dataWriteInENVFile('PAYPAL_SANDBOX_CLIENT_SECRET',$request->secret);


            if (empty($setting_paypal)) {
                SettingPaypal::create($data);
            }else {
                SettingPaypal::whereId($setting_paypal->id)->update($data);
            }
            return response()->json(['success' => __('Data Added successfully.')]);
        }
    }


    public function stripStoreOrUpdate(Request $request)
    {
        if ($request->ajax()) {

            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }

            $validator = Validator::make($request->only('label','description','publishable_key','secret_key'),[
                'label' => 'required',
                'description' => 'required',
                'publishable_key' => 'required',
                'secret_key' => 'required',
            ]);

            if ($validator->fails()){
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $data = [];
            $data['status'] = $request->status;
            $data['label'] = $request->label;
            $data['description'] = $request->description;
            $data['publishable_key'] = $request->publishable_key;
            $data['secret_key'] = $request->secret_key;

            $setting_strip = SettingStrip::latest()->first();

            if (empty($setting_strip)) {
                SettingStrip::create($data);
            }else {
                SettingStrip::whereId($setting_strip->id)->update($data);
            }

            $this->dataWriteInENVFile('STRIPE_KEY',$request->publishable_key);
            $this->dataWriteInENVFile('STRIPE_SECRET',$request->secret_key);

            return response()->json(['success' => __('Data Added successfully.')]);
        }
    }


    public function sslcommerzStoreOrUpdate(Request $request)
    {
        if ($request->ajax()) {

            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }

            $this->dataWriteInENVFile('SSL_COMMERZ_STATUS',$request->status);
            $this->dataWriteInENVFile('STORE_ID',$request->store_id);
            $this->dataWriteInENVFile('STORE_PASSWORD',$request->store_password);

            return response()->json(['success' => __('Data Added successfully.')]);
        }
    }

    public function razorpayStoreOrUpdate(Request $request)
    {
        if ($request->ajax()) {

            if (!env('USER_VERIFIED')) {
                return response()->json(['errors' => ['This is disabled for demo']]);
            }
            $validator = Validator::make($request->only('razorpay_key','razorpay_secret'),[
                'razorpay_key' => 'required',
                'razorpay_secret' => 'required',
            ]);

            if ($validator->fails()){
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $this->dataWriteInENVFile('RAZORPAY_STATUS',$request->status);
            $this->dataWriteInENVFile('RAZORPAY_KEY',$request->razorpay_key);
            $this->dataWriteInENVFile('RAZORPAY_SECRET',$request->razorpay_secret);

            return response()->json(['success' => __('Data Added successfully.')]);
        }
    }

    public function paystackStoreOrUpdate(Request $request)
    {
        if ($request->ajax()) {
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors' => ['This is disabled for demo']]);
            }
            $validator = Validator::make($request->only('paystack_public_key','paystack_secret_key','merchant_email'),[
                'paystack_public_key' => 'required',
                'paystack_secret_key' => 'required',
                'merchant_email'      => 'required',
            ]);

            if ($validator->fails()){
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $this->dataWriteInENVFile('PAYSTACK_STATUS',$request->status);
            $this->dataWriteInENVFile('PAYSTACK_PUBLIC_KEY',$request->paystack_public_key);
            $this->dataWriteInENVFile('PAYSTACK_SECRET_KEY',$request->paystack_secret_key);
            $this->dataWriteInENVFile('MERCHANT_EMAIL',$request->merchant_email);

            return response()->json(['success' => __('Data Added successfully.')]);
        }
    }

    public function paytmStoreOrUpdate(Request $request)
    {
        if ($request->ajax()) {
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }

            $validator = Validator::make($request->only('label','description','merchant_id','merchant_key'),[
                'label' => 'required',
                'description' => 'required',
                'merchant_id' => 'required',
                'merchant_key' => 'required',
            ]);

            if ($validator->fails()){
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $data = [];
            $data['status'] = $request->status;
            $data['label'] = $request->label;
            $data['description'] = $request->description;
            $data['sandbox'] = $request->sandbox;
            $data['merchant_id'] = $request->merchant_id;
            $data['merchant_key'] = $request->merchant_key;

            $setting_paytm = SettingPaytm::latest()->first();

            if (empty($setting_paytm)) {
                SettingPaytm::create($data);
            }else {
                SettingPaytm::whereId($setting_paytm->id)->update($data);
            }
            return response()->json(['success' => __('Data Added successfully.')]);
        }
    }

    public function cashonDeliveryStoreOrUpdate(Request $request)
    {
        if ($request->ajax()) {
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }
            $validator = Validator::make($request->only('label','description'),[
                'label' => 'required',
                'description' => 'required',
            ]);

            if ($validator->fails()){
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $data = [];
            $data['status'] = $request->status;
            $data['label'] = $request->label;
            $data['description'] = $request->description;

            $setting_cash_on_delivery = SettingCashOnDelivery::latest()->first();

            if (empty($setting_cash_on_delivery)) {
                SettingCashOnDelivery::create($data);
            }else {
                SettingCashOnDelivery::whereId($setting_cash_on_delivery->id)->update($data);
            }
            return response()->json(['success' => __('Data Added successfully.')]);
        }
    }

    public function bankTransferStoreOrUpdate(Request $request)
    {
        if ($request->ajax()) {
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }
            $validator = Validator::make($request->only('label','description','instruction'),[
                'label' => 'required',
                'description' => 'required',
                'instruction' => 'required',
            ]);

            if ($validator->fails()){
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $data = [];
            $data['status'] = $request->status;
            $data['label'] = $request->label;
            $data['description'] = $request->description;
            $data['instruction'] = $request->instruction;

            $setting_bank_transfer = SettingBankTransfer::latest()->first();

            if (empty($setting_bank_transfer)) {
                SettingBankTransfer::create($data);
            }else {
                SettingBankTransfer::whereId($setting_bank_transfer->id)->update($data);
            }
            return response()->json(['success' => __('Data Added successfully.')]);
        }
    }

    public function cehckMoneyOrderStoreOrUpdate(Request $request)
    {
        if ($request->ajax()) {
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }
            $validator = Validator::make($request->only('label','description','instruction'),[
                'label' => 'required',
                'description' => 'required',
                'instruction' => 'required',
            ]);

            if ($validator->fails()){
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $data = [];
            $data['status'] = $request->status;
            $data['label'] = $request->label;
            $data['description'] = $request->description;
            $data['instruction'] = $request->instruction;

            $setting_check_money_order = SettingCheckMoneyOrder::latest()->first();

            if (empty($setting_check_money_order)) {
                SettingCheckMoneyOrder::create($data);
            }else {
                SettingCheckMoneyOrder::whereId($setting_check_money_order->id)->update($data);
            }
            return response()->json(['success' => __('Data Added successfully.')]);
        }
    }


    public function emptyDatabase()
	{
        if(!env('USER_VERIFIED')){
			return redirect()->back()->with('empty_message', 'This feature is disabled for demo !');
		}
		DB::statement("SET foreign_key_checks=0");
		$tables = DB::select('SHOW TABLES');
		$str = 'Tables_in_' . env('DB_DATABASE');
		foreach ($tables as $table) {
			// if($table->$str != 'countries' && $table->$str != 'model_has_roles' && $table->$str != 'role_users' && $table->$str != 'general_settings'  && $table->$str != 'migrations' && $table->$str != 'password_resets' && $table->$str != 'permissions' &&  $table->$str != 'roles' && $table->$str != 'role_has_permissions' && $table->$str != 'users') {
			if($table->$str != 'colors' && $table->$str != 'countries' && $table->$str != 'model_has_roles' && $table->$str != 'currencies'  && $table->$str != 'migrations' && $table->$str != 'languages' && $table->$str != 'permissions' &&  $table->$str != 'roles' && $table->$str != 'role_has_permissions' && $table->$str != 'users' && $table->$str != 'settings' && $table->$str != 'setting_translations' && $table->$str != 'storefront_images') {
				DB::table($table->$str)->truncate();
			}
		}
		DB::statement("SET foreign_key_checks=1");
		return redirect()->back()->with('empty_message', 'Database cleared successfully');
	}


}

