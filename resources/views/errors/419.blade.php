@extends('frontend.layouts.master')

@section('title','419 | Page Expired')

@section('frontend_content')


<section class="error-section mt-5 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="error-icon">
                    <i class="ion-sad-outline"></i>
                </div>
            </div>
            <div class="col-md-8 offset-md-2  error-text text-center">
                <i class="las la-exclamation-triangle" style="color:var(--theme-color);font-size: 90px;margin-bottom:30px"></i>
                <h2 class="h1">@lang('file.Sorry this page is dead!')</h2>
                <p class="lead">@lang('file.The page is expired due to session expiration. Just refresh the page or hit the button below.') <a class="btn-link" href="#">@lang('file.Refresh')</a> </p>
            </div>
        </div>
    </div>
</section>

@endsection

