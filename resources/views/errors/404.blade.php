@extends('frontend.layouts.master')

@section('title','404 | Page Not Found')

@section('frontend_content')


<section class="error-section mt-5 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="error-icon">
                    <i class="ion-sad-outline"></i>
                </div>
            </div>
            <div class="col-md-6 offset-md-3  error-text text-center">
                <i class="las la-binoculars"style="color:var(--theme-color);font-size: 90px;margin-bottom:30px"></i>
                <h2 class="h1">@lang('file.Oh snap! We are lost...')</h2>
                <p class="lead">@lang('file.It seems we can not find what you are looking for. Perhaps searching can help or go back to')
                <br><br>
                <a class="button style1" href="{{route('cartpro.home')}}">@lang('file.Home')</a> </p>
            </div>
        </div>
    </div>
</section>

@endsection
