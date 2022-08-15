@extends('frontend.layouts.master')
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
                    <h2 class="h1">@lang('file.Your cart is empty. Please add to cart first')</h2>
                </div>
            </div>
        </div>
    </section>
@endsection
