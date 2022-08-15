@extends('frontend.layouts.master')

@section('title','404 | Page Not Found')

@section('frontend_content')


<section class="error-section pb-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="error-icon">
                    <i class="ion-sad-outline"></i>
                </div>
            </div>
            <div class="col-md-8 offset-md-2  error-text text-center">
                <h2 class="h1">@lang('file.Error 404, Page Not Found')</h2>
                <p class="lead">@lang('file.It seems we can not find what you are looking for. Perhaps searching can help or go back to') <a class="btn-link" href="{{route('cartpro.home')}}">Home</a> </p>
            </div>
        </div>
    </div>
</section>

@endsection
