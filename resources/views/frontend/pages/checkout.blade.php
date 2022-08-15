@extends('frontend.layouts.master')
@section('extra_css')
@section('frontend_content')

<div class="container">

    <!--Breadcrumb Area start-->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <ul>
                        <li><a href="{{route('cartpro.home')}}">@lang('file.Home')</a></li>
                        <li class="active">@lang('file.Checkout')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb Area ends-->


    <!-- Content Wrapper -->
    <section class="content-wrapper mt-0 mb-5">
        <div class="container">
            <div class="row">

                <div class="col-12">
                    <h1 class="page-title h2 text-center uppercase mt-1 mb-5">@lang('file.Checkout')</h1>
                    @if (!Auth::check())
                        <div class="col-md-6 offset-md-3 col-sm-12 text-right mar-bot-20">
                            <div class="alert alert-secondary text-center res-box" role="alert">
                                <div class="alert-icon"><i class="ion-android-favorite-outline mr-2"></i> <span>@lang('file.Register Customer') ? </span>
                                    <a target="__blank" href="" class="semi-bold theme-color" data-bs-toggle="modal" data-bs-target="#exampleModal">@lang('file.Click here to login')</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>


                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
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
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('file.Close')</button>
                        </div>
                    </div>
                    </div>
                </div>


                <!-- Alert Message -->
                <div class="d-flex justify-content-center d-none" id="alert_div">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div id="alert_message">
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>

            @if (session()->has('message'))
                <div class="d-flex justify-content-center">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ session('message')}}!</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <!-- Error Message -->
            @include('frontend.includes.error_message')
            <!-- Error Message -->

            <div class="row">
                <form action="{{route('payment.process')}}" method="POST" novalidate
                    role="form"
                    class="require-validation"
                    data-cc-on-file="false"
                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                    id="payment-form">
                    @csrf
                    <input type="hidden" name="shipping_type" id="shippingType">
                    <input type="hidden" name="totalAmount" class="cart_total" id="totalAmount" value="{{$cart_total}}">
                    <input type="hidden" name="tax_id" id="taxId">
                    <input type="hidden" name="shipping_cost_temp" id="shippingCost">
                    <input type="hidden" name="coupon_code_temp" id="couponCode">
                    <input type="hidden" name="coupon_value_temp" id="couponValue">


                    <!-- Paystack -->
                    <input type="hidden" name="email" id="emailPaystack" @auth value="{{auth()->user()->email}}" @endauth>
                    <input type="hidden" name="orderID" value="345">
                    <input type="hidden" name="amount" id="totalAmountPaystack" class="cart_total" value="{{$cart_total}}">
                    <input type="hidden" name="quantity" value="{{Cart::count()}}">
                    <input type="hidden" name="currency" value="NGN">
                    <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
                    <!--/ Paystack -->


                    <div class="row">
                        <div class="col-md-6 mar-top-30">
                            <h3 class="section-title">@lang('file.Billing Details')</h3>

                            <div class="row">
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="billing_first_name" @auth value="{{auth()->user()->first_name}}" @endauth placeholder="@lang('file.First Name') *">
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="billing_last_name" @auth value="{{auth()->user()->last_name}}" @endauth  placeholder="@lang('file.Last Name') *">
                                </div>


                                <div class="col-sm-6">
                                    <input class="form-control" type="email" name="billing_email" @auth value="{{auth()->user()->email}}" @endauth placeholder="@lang('file.Email') *">
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" type="number" name="billing_phone" @auth value="{{auth()->user()->phone}}" @endauth min='0' onkeypress="return isNumberKey(event)" placeholder="@lang('file.Phone') *">
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <select class="form-control" name="billing_country" id="billingCountry">
                                            <option value="">* @lang('file.Select Country')</option>
                                            @foreach ($countries as $country)
                                                <option value="{{$country->country_name}}" @isset($billing_address) {{$country->country_name==$billing_address->country ? 'selected':''}}  @endisset>{{$country->country_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <input class="form-control" type="text" name="billing_address_1" @isset($billing_address) value="{{$billing_address->address_1 ?? ''}}" @endisset placeholder="@lang('file.Street Address')">
                                </div>
                                <div class="col-12">
                                    <input class="form-control" type="text" name="billing_address_2" @isset($billing_address) value="{{$billing_address->address_2 ?? ''}}" @endisset placeholder="@lang('file.Apartment, suite, unit etc. (optional)')">
                                </div>
                                <div class="col-12">
                                    <input class="form-control" type="text" name="billing_city" @isset($billing_address) value="{{$billing_address->city ?? ''}}" @endisset placeholder="@lang('file.City / Town')">
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="billing_state" @isset($billing_address) value="{{$billing_address->state ?? ''}}" @endisset placeholder="@lang('file.State / County')">
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="billing_zip_code" @isset($billing_address) value="{{$billing_address->zip_code ?? ''}}" @endisset placeholder="@lang('file.Postcode / Zip')">
                                </div>
                            </div>

                            @if (!Auth::check())
                                <div class="custom-control custom-checkbox mt-5" data-bs-toggle="collapse" href="#create_account_collapse" role="button" aria-expanded="false" aria-controls="create_account_collapse">
                                    <input type="checkbox" class="custom-control-input" name="billing_create_account_check" id="billing_create_account_check" value="1">
                                    <label class="label custom-control-label" for="create_account">@lang('file.Create Account')</label>
                                </div>
                            @endif

                            <div class="collapse" id="create_account_collapse">
                                <input class="form-control mt-3 @error('username') is-invalid @enderror" value="{{ old('username') }}" type="text" placeholder="@lang('file.Enter Username')" name="username">
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <input class="form-control mt-3 @error('password') is-invalid @enderror" type="password" placeholder="@lang('file.Enter Password')" name="password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <input class="form-control mt-3 @error('password_confirmation') is-invalid @enderror" type="password" placeholder="@lang('file.Enter Confirm Password')" name="password_confirmation">
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="custom-control custom-checkbox mt-4 mb-3" data-bs-toggle="collapse" href="#shipping_address_collapse" role="button" aria-expanded="false" aria-controls="shipping_address_collapse">
                                <input type="checkbox" class="custom-control-input" id="shipping_address_check" name="shipping_address_check" value="1">
                                <label class="label custom-control-label" for="shipping_address_check">@lang('file.Ship to a different address')</label>
                            </div>

                            <div class="collapse" id="shipping_address_collapse">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text" name="shipping_first_name" placeholder="@lang('file.First Name') *">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text" name="shipping_last_name" placeholder="@lang('file.Last Name') *">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text" name="shipping_email" placeholder="@lang('file.Email')">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text" name="shipping_phone" min='0' onkeypress="return isNumberKey(event)" placeholder="@lang('file.Phone')">
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <select class="form-control" name="shipping_country" id="shipping_country">
                                                <option value="">@lang('file.Select Country')</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{$country->country_name}}" @isset($shipping_address) {{$country->country_name==$shipping_address->country ? 'selected':''}}  @endisset>{{$country->country_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <input class="form-control" type="text" name="shipping_address_1" @isset($shipping_address) value="{{$shipping_address->address_1 ?? ''}}" @endisset placeholder="@lang('file.Street Address')">
                                    </div>
                                    <div class="col-12">
                                        <input class="form-control" type="text" name="shipping_address_2" @isset($shipping_address) value="{{$shipping_address->address_2 ?? ''}}" @endisset placeholder="@lang('file.Apartment, suite, unit etc. (optional)')">
                                    </div>
                                    <div class="col-12">
                                        <input class="form-control" type="text" name="shipping_city" @isset($shipping_address) value="{{$shipping_address->city ?? ''}}" @endisset placeholder="@lang('file.City / Town')">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text" name="shipping_state" @isset($shipping_address) value="{{$shipping_address->state ?? ''}}" @endisset placeholder="@lang('file.State / County')">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text" name="shipping_zip_code" @isset($shipping_address) value="{{$shipping_address->zip_code ?? ''}}" @endisset placeholder="@lang('file.Postcode / Zip')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mar-top-30">
                            <h3 class="section-title">@lang('file.Your order')</h3>
                            <div class="cart-subtotal">
                                <div class="table-content table-responsive cart-table">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>@lang('file.Product')</th>
                                                <th class="text-center">@lang('file.Total')</th>
                                            </tr>
                                        </thead>
                                        <tbody class="cartTable">
                                            <div id="content">
                                                @forelse ($cart_content as $item)
                                                    <tr id="{{$item->rowId}}">
                                                        <td class="cart-product">
                                                            <div class="item-details">
                                                                <img class="lazy" data-src="{{asset('public/'.$item->options->image ?? null)}}" alt="...">
                                                                <div>
                                                                    <h3 class="h6">{{$item->name}}</h3>
                                                                    <div class="input-qty">
                                                                        <input type="text" class="input-number" readonly value="{{$item->qty}}">
                                                                        X
                                                                        <span class="amount">&nbsp;
                                                                            @if(env('CURRENCY_FORMAT')=='suffix')
                                                                                <span>{{$item->price  * $CHANGE_CURRENCY_RATE}}</span> @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                                            @else
                                                                                @include('frontend.includes.SHOW_CURRENCY_SYMBOL') <span>{{$item->price * $CHANGE_CURRENCY_RATE}}</span>
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="cart-product-subtotal"><span class="amount">
                                                            @if(env('CURRENCY_FORMAT')=='suffix')
                                                                <span class="subtotal_{{$item->rowId}}"> {{ number_format((float)$item->subtotal * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}</span> @include('frontend.includes.SHOW_CURRENCY_SYMBOL')</span>
                                                            @else
                                                                @include('frontend.includes.SHOW_CURRENCY_SYMBOL') <span class="subtotal_{{$item->rowId}}">{{ number_format((float)$item->subtotal * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                @endforelse
                                            </div>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="subtotal mt-3">
                                    <div class="label">@lang('file.Subtotal')</div>
                                    <input type="hidden" name="subtotal" class="cartSubtotal" value="{{$cart_subtotal}}">

                                    <div class="price">
                                        @if(env('CURRENCY_FORMAT')=='suffix')
                                            <span class="cartSubtotal">{{ number_format((float)$cart_subtotal * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}</span> @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                        @else
                                            {{-- @include('frontend.includes.SHOW_CURRENCY_SYMBOL') <span class="cartSubtotal">{{ number_format((float)$cart_subtotal * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}</span> --}}
                                            @include('frontend.includes.SHOW_CURRENCY_SYMBOL') <span class="cartSubtotal">{{$cart_subtotal}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="custom-control custom-checkbox" data-bs-toggle="collapse" href="#apply_coupon_collapse" role="button" aria-expanded="false" aria-controls="apply_coupon_collapse">
                                    <input type="checkbox" class="custom-control-input" id="apply_coupon" name="coupon_checked" value="1">
                                    <label class="label custom-control-label" for="apply_coupon">@lang('I have a coupon')</label>
                                </div>
                                <div class="collapse" id="apply_coupon_collapse">
                                    <div class="newsletter" id="applyCoupon">
                                        <input type="text" placeholder="@lang('file.Enter Coupon Code')" name="coupon_code" id="coupon_code">
                                        <input type="hidden" name="coupon_value" id="coupon_value">
                                        <button class="button style1 btn-search" type="submit">@lang('file.Apply')</button>
                                    </div>
                                </div>
                                <div class="shipping">
                                    <div class="label">@lang('file.Shiping')</div>

                                    @if (isset($setting_free_shipping) && $setting_free_shipping->shipping_status==1)
                                        <div class="custom-control custom-radio mt-3">
                                            <input type="radio" id="customRadio1" data-shipping_type='free' name="shipping_cost" class="custom-control-input shippingCharge" value="{{$setting_free_shipping->minimum_amount ?? 0}}">
                                            <label class="custom-control-label" for="customRadio1">{{$setting_free_shipping->label ?? null}}
                                                <span class="price">
                                                    @if(env('CURRENCY_FORMAT')=='suffix')
                                                        {{ number_format((float)$setting_free_shipping->minimum_amount * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                    @else
                                                        @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$setting_free_shipping->minimum_amount  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                    @endif
                                                </span>
                                            </label>
                                        </div>
                                    @endif

                                    @if (isset($setting_local_pickup) && $setting_local_pickup->pickup_status==1)
                                        <div class="custom-control custom-radio mt-3">
                                            <input type="radio" id="customRadio2" data-shipping_type='local_pickup' name="shipping_cost" class="custom-control-input shippingCharge" value="{{$setting_local_pickup->cost ?? null}}">
                                            <label class="custom-control-label" for="customRadio2">{{$setting_local_pickup->label ?? null}}
                                                <span class="price">
                                                    @if(env('CURRENCY_FORMAT')=='suffix')
                                                        {{ number_format((float)$setting_local_pickup->cost * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                    @else
                                                        @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$setting_local_pickup->cost  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                    @endif
                                                </span>
                                            </label>
                                        </div>
                                    @endif

                                    @if (isset($setting_flat_rate) && $setting_flat_rate->flat_status==1)
                                        <div class="custom-control custom-radio mt-3">
                                            <input type="radio" id="customRadio3" data-shipping_type='flat_rate' name="shipping_cost" class="custom-control-input shippingCharge" value="{{$setting_flat_rate->cost ?? null}}">
                                            <label class="custom-control-label" for="customRadio3">{{$setting_flat_rate->label ?? null}}
                                                <span class="price">
                                                    @if(env('CURRENCY_FORMAT')=='suffix')
                                                        {{ number_format((float)$setting_flat_rate->cost * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                    @else
                                                        @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$setting_flat_rate->cost * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                    @endif
                                                </span>
                                            </label>
                                        </div>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-between">
                                    <div class="label">{{__('file.Tax')}}</div>
                                    <div class="price">
                                        @if(env('CURRENCY_FORMAT')=='suffix')
                                            <span class="tax_rate">0</span> @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                        @else
                                            @include('frontend.includes.SHOW_CURRENCY_SYMBOL') <span class="tax_rate">0</span>
                                        @endif
                                    </div>
                                </div>

                                <hr>

                                <div class="total">
                                    <div class="label">{{__('file.Total')}}</div>
                                    <div class="price">
                                        @if(env('CURRENCY_FORMAT')=='suffix')
                                            <span class="total_amount">{{$cart_total}}</span> @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                        @else
                                            @include('frontend.includes.SHOW_CURRENCY_SYMBOL') <span class="total_amount">{{$cart_total}}</span>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="payment-options">

                                    <div>
                                        @if (isset($cash_on_delivery) && $cash_on_delivery->status==1)
                                            <label class="custom-checkbox">
                                                <input type="radio" name="payment_type" id="cashOnDelivery" value="cash_on_delivery">
                                                <span class="sm-heading">@lang('file.Cash On Delivery')</span>
                                            </label>
                                        @endif

                                        @if (isset($paypal) && $paypal->status==1)
                                            <label class="custom-checkbox">
                                                <input type="radio" name="payment_type" id='paypal' value="paypal">
                                                <span class="card-options"><img class="lazy" data-src="{{asset('public/frontend/images/payment_gateway_logo/paypal.jpg')}}" alt="..."></span>
                                                <span class="sm-heading">{{__('file.Paypal')}}</span>
                                            </label>
                                        @endif

                                        @if (isset($stripe) && $stripe->status==1)
                                            <label class="custom-checkbox">
                                                <input type="radio" name="payment_type" id='stripe' value="stripe">
                                                <span class="card-options"><img class="lazy" data-src="{{asset('public/frontend/images/payment_gateway_logo/stripe.png')}}" alt="..."></span>
                                                <span class="sm-heading">{{__('file.Stripe')}}</span>
                                            </label>
                                        @endif

                                        @if (env('SSL_COMMERZ_STATUS')==1)
                                            <label class="custom-checkbox">
                                                <input type="radio" name="payment_type" id='sslcommerz' value="sslcommerz">
                                                <span class="card-options"><img class="lazy" data-src="{{asset('public/frontend/images/payment_gateway_logo/ssl_commerz.png')}}" alt="..."></span>
                                                <span class="sm-heading">{{__('file.SSL Commerz')}}</span>
                                            </label>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        @if (env('RAZORPAY_STATUS')==1)
                                            <label class="custom-checkbox">
                                                <input type="radio" name="payment_type" id='razorpay' value="razorpay">
                                                <span class="card-options"><img class="lazy" data-src="{{asset('public/frontend/images/payment_gateway_logo/razorpay.png')}}"></span>
                                                <span class="sm-heading">{{__('file.Razorpay')}}</span>
                                            </label>
                                        @endif
                                        @if (env('PAYSTACK_STATUS')==1)
                                            <label class="custom-checkbox">
                                                <input type="radio" name="payment_type" id='paystack' value="paystack">
                                                <span class="card-options"><img class="lazy" data-src="{{asset('public/frontend/images/payment_gateway_logo/paystack.png')}}"></span>
                                                <span class="sm-heading">{{__('file.Paystack')}}</span>
                                            </label>
                                        @endif
                                    </div>
                                    <div class="custom-control custom-checkbox text-center mt-5 mb-5">
                                        <input type="checkbox" class="custom-control-input" id="acceptTerms">
                                        <label class="custom-control-label" for="acceptTerms">@lang('file.I have read and accecpt the') <a class="theme-color" @isset($terms_and_condition_page_slug) href="{{route('page.Show',$terms_and_condition_page_slug)}}" target="__blank" @endisset >Terms & Conditions</a></label>
                                    </div>
                                </div>
                            </div>

                            <!--Paypal-->
                            <div id="paypal-button-container"></div>

                            <div class="mb-3 d-none" id="stripeSection">
                                <div class='form-row row'>
                                    <div class='col-xs-12 form-group'>
                                        <input class='form-control' size='4' type='text' name="card_name" placeholder="@lang('file.Name on Card')">
                                    </div>
                                </div>

                                <div class='form-row row'>
                                    <div class='col-xs-12 form-group'>
                                        <input autocomplete='off' name="card_number" class='form-control card-number' placeholder="@lang('file.Card Number')" size='20' type='text'>
                                    </div>
                                </div>

                                <div class='form-row row'>
                                    <div class='col-xs-12 col-md-4 form-group cvc'>
                                        <input autocomplete='off' name="card-cvc" class='form-control card-cvc' size='4' type='text' placeholder="CVC (ex. 311)">
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration'>
                                        <input class='form-control card-expiry-month' name="card-expiry-month" size='2' type='text' placeholder="Expiration Month (MM)">
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration'>
                                        <input class='form-control card-expiry-year' name="card-expiry-year" placeholder='Expiration Year (YYYY)' size='4' type='text'>
                                    </div>
                                </div>
                            </div>

                            <div class="checkout-actions mar-top-30 pay_now_div">
                                <button type="submit" class="btn button lg style1 d-block text-center w-100" disabled title="disabled" id="orderBtn">{{__('file.Pay Now')}}</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </section>
</div>
@endsection

@push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <script src="https://www.paypal.com/sdk/js?client-id={{env('PAYPAL_SANDBOX_CLIENT_ID')}}&currency=USD" data-namespace="paypal_sdk"></script>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>


    <script type="text/javascript">
        $(function(){


            var billingCountry = $("#billingCountry").val();
            if (billingCountry) {
                var couponCode   = $('#couponCode').val();
                var shippingCost = $("#shippingCost").val();
                $.ajax({
                    url: "{{ route('cart.country_wise_tax') }}",
                    type: "GET",
                    data: {
                        billing_country:billingCountry,
                        coupon_code:couponCode,
                        shipping_cost:shippingCost,
                    },
                    success: function (data) {
                        $('.tax_rate').text(data.tax_rate);
                        $('#taxId').val(data.tax_id); //For Form
                        $('.total_amount').text(data.total_amount);
                        $('#totalAmount').val(data.total_amount); //For Form

                        $('#totalAmountPaystack').val(data.total_amount); //For Paystack
                    }
                });
            }

            $('#billingCountry').change(function() {
                var billingCountry = $("#billingCountry").val();
                var couponCode = $('#couponCode').val();
                var shippingCost = $("#shippingCost").val();
                $.ajax({
                    url: "{{ route('cart.country_wise_tax') }}",
                    type: "GET",
                    data: {
                        billing_country:billingCountry,
                        coupon_code:couponCode,
                        shipping_cost:shippingCost,
                    },
                    success: function (data) {
                        console.log(data);
                        $('.tax_rate').text(data.tax_rate);
                        $('#taxId').val(data.tax_id); //For Form
                        $('.total_amount').text(data.total_amount);
                        $('#totalAmount').val(data.total_amount); //For Form

                        $('#totalAmountPaystack').val(data.total_amount); //For Paystack

                    }
                })
            });


            //Coupon
            $('#applyCoupon').on("click",function(e){
                e.preventDefault();
                var taxId = $('#taxId').val();
                var shippingCost = $('.shippingCharge:checked').val();
                var coupon_code = $('#coupon_code').val();
                $.ajax({
                    url: "{{ route('cart.apply_coupon') }}",
                    type: "GET",
                    data: {tax_id:taxId, coupon_code:coupon_code,shipping_cost:shippingCost},
                    success: function (data) {
                        console.log(data)
                        if (data.type=='success') {
                            $('.tax_rate').text(data.tax_rate);
                            $('#taxId').val(data.tax_id); //For Form
                            $('.total_amount').text(data.total_amount);
                            $('#totalAmount').val(data.total_amount); //For Form
                            $('#couponValue').val(data.coupon_value); //For Form

                            $('#totalAmountPaystack').val(data.total_amount); //For Paystack
                        }
                    }
                })
            });


            //Shipping
            $('.shippingCharge').on("click",function(e){
                var shippingCost = $(this).val();
                $('#shippingCost').val(shippingCost);

                var shipping_type = $(this).data('shipping_type');
                $('#shippingType').val(shipping_type);

                var couponValue = $('#couponValue').val();
                var taxId = $('#taxId').val();

                $.ajax({
                    url: "{{ route('cart.shipping_charge') }}",
                    type: "GET",
                    data: {shipping_cost:shippingCost,coupon_value:couponValue,tax_id:taxId},
                    success: function (data) {
                        console.log(data)
                        if (data.type=='success') {
                            $('#couponValue').val(data.coupon_value); //For Form
                            $('.tax_rate').text(data.tax_rate);
                            $('#taxId').val(data.tax_id); //For Form
                            $('.total_amount').text(data.total_amount);
                            $('#totalAmount').val(data.total_amount); //For Form

                            $('#totalAmountPaystack').val(data.total_amount); //For Paystack

                        }
                    }
                })
            });


            let paymentType;
            //----------- Submit ----------
            $('input[name="payment_type"]').change(function(){
                paymentType = $(this).val();

                $('#acceptTerms').prop('checked', false);
                $('#paypal-button-container').empty();
                $('.pay_now_div').show();
                $('#orderBtn').prop("disabled",true).prop("title",'Disable');

                if (paymentType!='stripe'){
                    $('#stripeSection').addClass('d-none');
                }

                $('#acceptTerms').change(function() {
                    if(this.checked) {
                        if (paymentType=='cash_on_delivery' || paymentType=='sslcommerz') {
                            $("#payment-form").unbind();
                            $('#stripeSection').addClass('d-none');
                            $('#paypal-button-container').empty();
                            $('.pay_now_div').show();
                            $('#orderBtn').prop("disabled",false).prop("title",'Pay Now');
                        }
                        else if (paymentType=='paypal') {
                            $("#payment-form").unbind();
                            $('#stripeSection').addClass('d-none');
                            $('.pay_now_div').hide();
                            var totalAmountP = parseFloat($("input[name=totalAmount]").val()).toFixed(2);
                            paypal_sdk.Buttons({
                                createOrder: function(data, actions) {
                                    $.ajax({
                                        url: "{{route('payment.process')}}",
                                        method: "POST",
                                        data: $('#payment-form').serialize(),
                                        success: function (data) {
                                            var x = 2;
                                        }
                                    });
                                    return actions.order.create({
                                        purchase_units: [{
                                            amount: {
                                                value: totalAmountP,
                                                currency_code: "USD",
                                            }
                                        }]
                                    });
                                },
                                onApprove: function(data, actions) {
                                    return actions.order.capture().then(function(details) {
                                    });
                                }
                            }).render('#paypal-button-container');
                        }
                        else if (paymentType=='stripe') {
                            $('#stripeSection').removeClass('d-none');
                            $('#orderBtn').prop("disabled",false).prop("title",'Pay Now');

                            var $form         = $(".require-validation");
                            $('form').bind('submit', function(e) {
                                if (!$form.data('cc-on-file')) {
                                    e.preventDefault();
                                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                                    Stripe.createToken({
                                    number: $('.card-number').val(),
                                    cvc: $('.card-cvc').val(),
                                    exp_month: $('.card-expiry-month').val(),
                                    exp_year: $('.card-expiry-year').val()
                                }, stripeResponseHandler);
                                }
                            });

                            function stripeResponseHandler(status, response) {
                                if (response.error) {
                                    $('.error')
                                        .removeClass('hide')
                                        .find('.alert')
                                        .text(response.error.message);
                                } else {
                                    // token contains id, last4, and card type
                                    var token = response['id'];
                                    // insert the token into the form so it gets submitted to the server
                                    $form.find('input[type=text]').empty();
                                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                                    $form.get(0).submit();
                                }
                            }
                        }
                        else if (paymentType=='razorpay' || paymentType=='paystack'){
                            $('#orderBtn').prop("disabled",false).prop("title",'Pay Now');
                        }
                    }
                });
            });

            $('#orderBtn').on("click",function(e){
                if (paymentType=='razorpay'){
                    e.preventDefault();
                    $('totalAmount').val();
                        var options = {
                                        "key": "{{env('RAZORPAY_KEY')}}",
                                        "amount": $('#totalAmount').val()*100,
                                        "currency": "INR",
                                        // "name": "Acme Corp",
                                        // "description": "Test Transaction",
                                        // "image": "https://cdn.razorpay.com/logos/F9Yhfb7ZXjXmIQ_medium.png",
                                        // "handler": function (response){
                                        //     alert(response.razorpay_payment_id);
                                        //     alert(response.razorpay_order_id);
                                        //     alert(response.razorpay_signature)
                                        // },
                                        // "prefill": {
                                        //     "name": "Gaurav Kumar",
                                        //     "email": "gaurav.kumar@example.com",
                                        //     "contact": "9999988999"
                                        // },
                                        // "notes": {
                                        //     "address": "Razorpay Corporate Office"
                                        // },
                                        // "theme": {
                                        //     "color": "#3399cc"
                                        // }
                                    };
                                    var rzp1 = new Razorpay(options);
                        rzp1.open();
                    }
            });

            //-- For Paystack ------
            $('input[name="billing_email"]').keyup(function(){
                var billing_email = $('input[name="billing_email"]').val();
                 $('#emailPaystack').val(billing_email);
            });

        });
    </script>
@endpush
