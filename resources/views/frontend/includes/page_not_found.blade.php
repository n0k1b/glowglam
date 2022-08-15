@extends('frontend.layouts.master')

@section('title','Product Not Found')

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
            </div>
        </div>
    </div>
</section>

@endsection
