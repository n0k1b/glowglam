<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Login</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <link rel="preload" href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="preload" href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" as="style" onload="this.onload=null;this.rel='stylesheet'"></noscript>

    <link rel="preload" href="https://cartproshop.com/demo/public/vendor/bootstrap/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="preload" href="https://cartproshop.com/demo/public/vendor/bootstrap/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'"></noscript>

    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{asset('public/css/style.default.css')}}" id="theme-stylesheet"
          type="text/css">
    <!-- Custom stylesheet - for your changes-->
    <!-- Favicon-->
    <link rel="icon" href="{{asset($favicon_logo_path)}}" />
</head>
<body>
<div class="page login-page">
    <div class="container">
        <div class="form-outer text-center d-flex align-items-center">
            <div class="form-inner">
                <div class="logo"><span>{{$setting_store->store_name ?? NULL}}</span></div>

                @include('admin.includes.alert_message')


                <form method="POST" action="{{ route('admin.login') }}" id="login-form">
                    @csrf

                    <div class="form-group-material">
                        <input id="username" type="text" class="input-material @error('username') is-invalid @enderror"
                               name="username" value="{{ old('username') }}" required autofocus>
                        <label for="username" class="label-material">{{ __('Username') }}</label>

                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group-material">
                        <input id="password" type="password"
                               class="input-material @error('password') is-invalid @enderror" name="password" required
                               autocomplete="current-password">
                        <label for="password" class="label-material">{{ __('Password') }}</label>

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    {{-- <div class="custom-control custom-checkbox">
                        <input type="checkbox" value="1" class="custom-control-input" name="remember"
                               id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember">{{ __('Remember Me') }}</label>
                    </div> --}}
                    <br>
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form>
                <!-- This three buttons for demo only-->
                {{-- <button type="submit" class="btn btn-success btn-sm default admin-btn" id="admin-btn">@lang('file.LogIn as Admin')</button> --}}
                <br><br>
            </div>
            <div class="copyrights text-center">
                <p>{{ __('Developed by')}} <a href="" class="external">@lang('file.LionCoders')</a></p>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset('public/vendor/jquery/jquery-3.5.1.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/vendor/bootstrap/js/bootstrap.min.js') }}"></script>


<script type="text/javascript">

    (function($) {

        "use strict";

        $('.admin-btn').on('click', function () {
            $("input[name='username']").focus().val('admin');
            $("input[name='password']").focus().val('admin');
        });

        $('.customer-btn').on('click', function () {
            $("input[name='username']").focus().val('customer');
            $("input[name='password']").focus().val('customer');
        });
        // ------------------------------------------------------- //
        // Material Inputs
        // ------------------------------------------------------ //

        let materialInputs = $('input.input-material');

        // activate labels for prefilled values
        materialInputs.filter(function () {
            return $(this).val() !== "";
        }).siblings('.label-material').addClass('active');

        // move label on focus
        materialInputs.on('focus', function () {
            $(this).siblings('.label-material').addClass('active');
        });

        // remove/keep label on blur
        materialInputs.on('blur', function () {
            $(this).siblings('.label-material').removeClass('active');

            if ($(this).val() !== '') {
                $(this).siblings('.label-material').addClass('active');
            } else {
                $(this).siblings('.label-material').removeClass('active');
            }
        });
    })(jQuery);
</script>

</body>
</html>

