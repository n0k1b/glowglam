@extends('frontend.layouts.master')

@section('title','500 | Server Error')

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
                <i class="las la-heart-broken" style="color:var(--theme-color);font-size: 90px;margin-bottom:30px"></i>
                <h2 class="h1">@lang('file.Uh oh server just snapped!')</h2>
                <p class="lead">@lang('file.An error occured due to server not being to able to handle your request.')</p>
            </div>
        </div>
    </div>
</section>

@endsection
