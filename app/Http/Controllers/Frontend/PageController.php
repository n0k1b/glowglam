<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    public function pageShow($page_slug)
    {
        if(!Session::get('currentLocal')){
            Session::put('currentLocal', 'en');
            $locale = 'en';
        }else {
            $locale = Session::get('currentLocal');
        }
        $page =  Page::with('pageTranslation')->where('slug',$page_slug)->first();
        if ($page) {
            return view('frontend.pages.page',compact('page'));
        }else {
            return view('frontend.includes.page_not_found',compact('page'));
        }
    }

    public function aboutUs()
    {
        $page =  Page::with('pageTranslation')->where('slug','about-us')->first();

        return view('frontend.pages.page',compact('page'));
    }

    public function termAndCondition()
    {
        $page =  Page::with('pageTranslation')->where('slug','terms_and_conditions')->first();
        return view('frontend.pages.page',compact('page'));
    }

    public function faq()
    {
        $page =  Page::with('pageTranslation')->where('slug','faq')->first();

        return view('frontend.pages.page',compact('page'));
    }
}
