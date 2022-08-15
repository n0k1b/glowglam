@extends('frontend.layouts.master')
@section('frontend_content')
    <!--Breadcrumb Area start-->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="page-title">@lang('file.About Us')</h1>
                    <ul>
                        <li><a href="home.html">@lang('file.Home')</a></li>
                        <li class="active">@lang('file.About Us')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb Area ends-->

    <!--About Area starts-->
    <section class="about-text-area m-3">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <div class="about-text">
                        <span>@lang('file.About Us')</span>
                        <h2>{{$setting_about_us->aboutUsTranslation->title ?? $setting_about_us->aboutUsTranslationEnglish->title ?? null }}</h2>
                        <p>{{$setting_about_us->aboutUsTranslation->description ?? $setting_about_us->aboutUsTranslationEnglish->description ?? null }}</p>

                    </div>
                </div>
                <div class="col-md-6 offset-md-1 col-sm-12 no-pad-right">
                    @if (isset($setting_about_us->image) && Illuminate\Support\Facades\File::exists(public_path($setting_about_us->image)))
                        <div class="about-img bg-h" style="background-image: url({{url('public/'.$setting_about_us->image)}})">
                    @else
                        <img src="https://dummyimage.com/1920x1240/e5e8ec/e5e8ec&text=About Us">
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
