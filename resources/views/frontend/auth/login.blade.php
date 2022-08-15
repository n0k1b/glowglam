@extends('frontend.layouts.master')
@section('frontend_content')

<!--Breadcrumb Area start-->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col">
                <ul>
                    <li><a href="{{route('cartpro.home')}}">Home</a></li>
                    <li class="active">Login</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--Breadcrumb Area ends-->


<!--User login section starts-->
<section class="user-login-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 tabs style1 text-center">
                <ul class="ui-list nav nav-tabs justify-content-center mar-tb-30" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active semi-bold" data-bs-toggle="tab" href="#login" role="tab" aria-selected="true">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link semi-bold" data-bs-toggle="tab" href="#register" role="tab" aria-selected="false">Register</a>
                    </li>
                </ul>
            </div>

            @if (session()->has('message'))
                <div class="d-flex justify-content-center">
                    <div class="alert alert-{{session('warning_type')}} alert-dismissible fade show" role="alert">
                        <strong>{{ session('message')}}!</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <div class="col-md-6 offset-md-3">
                <div class="ui-dash tab-content mar-bot-30">

                    <!-- Login -->
                    <div class="tab-pane fade @if (!session()->has('error')) show active @endif" id="login" role="tabpanel">
                        <form id="login-form" action="{{route('customer.login')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="username" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
                            </div>
                            <div class="row mt-4">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('customer.password.request') }}" tabindex="5" class="forgot-password theme-color">@lang('file.Forgot Password')</a>
                                </div>
                            </div>
                            <div class="form-group mt-4 mb-1">
                                <button type="submit" class="button style1 d-block text-center w-100">{{__('file.Log In')}}</button>
                            </div>
                        </form>
                        <div class="social-profile-login text-center mb-5">
                            <h5>Or Login with</h5>
                            <ul class="footer-social login-social mar-top-20 pad-left-15">
                                <li><a class="google" href="{{route('login.google')}}"><i class="lab la-google"></i></a></li>
                                <li><a class="facebook" href="{{route('login.facebook')}}"><i class="lab la-facebook-f"></i></a></li>
                                <!--<li><a href="{{route('login.github')}}"><i class="ti-github"></i></a></li>-->
                            </ul>
                        </div>
                    </div>

                    <!-- Rgister -->
                    <div class="tab-pane fade @if (session()->has('error')) show active @endif" id="register" role="tabpanel">
                        <form id="register-form" action="{{route('customer.register')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="username" tabindex="1" class="form-control @error('username') is-invalid @enderror" placeholder="Username" value="{{ old('username') }}" autocomplete="username" autofocus>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" tabindex="1" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" value="{{ old('email') }}" autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" tabindex="2" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name="password_confirmation" tabindex="2" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password">
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mt-4 mb-1">
                                <button type="submit" class="button style1 d-block text-center w-100">{{__('file.Register Now')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--User login section endss-->

@endsection
