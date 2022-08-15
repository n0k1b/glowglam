@extends('admin.main')
@section('title','Admin | Setting')
@section('admin_content')

<style>
    #accordion .fa{
        margin-right: 0.5rem;
      	font-size: 24px;
      	font-weight: bold;
        position: relative;
    	top: 2px;
    }
    .card-header:first-child{
        padding:0px 0px 0px 10px
    }
</style>
<script>
    $(document).ready(function(){
        // Add down arrow icon for collapse element which is open by default
        $(".collapse.show").each(function(){
        	$(this).prev(".card-header").find(".fa").addClass("fa-angle-down").removeClass("fa-angle-right");
        });

        // Toggle right and down arrow icon on show hide of collapse element
        $(".collapse").on('show.bs.collapse', function(){
        	$(this).prev(".card-header").find(".fa").removeClass("fa-angle-right").addClass("fa-angle-down");
        }).on('hide.bs.collapse', function(){
        	$(this).prev(".card-header").find(".fa").removeClass("fa-angle-down").addClass("fa-angle-right");
        });
    });
</script>

<div class="container-fluid"><span id="alert_message"></span></div>
<div class="container-fluid mb-3">

        <div class="row">
            <div class="col-4">

        <div id="accordion">

            <!-- General Settings  -->
            <div class="card mb-0">
                <div class="card-header" id="generalSettings">
                    <div class="btn" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapseOne">
                        <h5 class="text-bold"><i class="fa fa-angle-right"></i>@lang('file.General Settings')</h5>
                    </div>
                </div>
                <div id="collapse1" class="collapse show" aria-labelledby="generalSettings" data-parent="#accordion">
                    <div class="card-body">
                        <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="general-settings" data-toggle="list" href="#general" role="tab" aria-controls="home">@lang('file.General')</a>
                            <a class="list-group-item list-group-item-action" id="store-settings" data-toggle="list" href="#store" role="tab" aria-controls="social">@lang('file.Store-Contact')</a>
                            <a class="list-group-item list-group-item-action" id="about-us-settings" data-toggle="list" href="#about-us" role="tab" aria-controls="social">@lang('file.About Us')</a>
                            <a class="list-group-item list-group-item-action" id="currency-settings" data-toggle="list" href="#currency" role="tab" aria-controls="settings">@lang('file.Currency')</a>
                            <a class="list-group-item list-group-item-action" id="mail-settings" data-toggle="list" href="#mail" role="tab" aria-controls="mail">@lang('file.Mail')</a>
                            <a class="list-group-item list-group-item-action" id="newsletter-settings" data-toggle="list" href="#newsletter" role="tab" aria-controls="newsletter">@lang('file.Newsletter')</a>
                            <a class="list-group-item list-group-item-action" id="emptyDatabase-settings" data-toggle="list" href="#emptyDatabase" role="tab" aria-controls="emptyDatabase">@lang('file.Empty Database')</a>
                        </div>
                    </div>
                </div>
            </div>

             <!-- Social Login  -->
             <div class="card mb-0">
                <div class="card-header" id="socialLogin">
                    <div class="btn" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapseOne">
                        <h5 class="text-bold"><i class="fa fa-angle-right"></i>@lang('file.Social Logins')</h5>
                    </div>
                </div>
                <div id="collapse2" class="collapse" aria-labelledby="socialLogin" data-parent="#accordion">
                    <div class="card-body">
                        <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action" id="facebook-social_login" data-toggle="list" href="#facebook" role="tab" aria-controls="facebook">@lang('file.Facebook')</a>
                            <a class="list-group-item list-group-item-action" id="google-social_login" data-toggle="list" href="#google" role="tab" aria-controls="google">@lang('file.Google')</a>
                            <a class="list-group-item list-group-item-action" id="github-social_login" data-toggle="list" href="#github" role="tab" aria-controls="github">@lang('file.Github')</a>
                        </div>
                    </div>
                </div>
             </div>
             <!-- Shipping Methods  -->
             <div class="card mb-0">
                <div class="card-header" id="shippingMethod">
                    <div class="btn" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapseOne">
                        <h5 class="text-bold"><i class="fa fa-angle-right"></i>@lang('file.Shipping Methods')</h5>
                    </div>
                </div>
                <div id="collapse3" class="collapse" aria-labelledby="shippingMethod" data-parent="#accordion">
                    <div class="card-body">
                        <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action" id="free_shipping-shipping_methods" data-toggle="list" href="#free_shipping" role="tab" aria-controls="free_shipping">@lang('file.Free Shipping')</a>
                            <a class="list-group-item list-group-item-action" id="local_pickup-shipping_methods" data-toggle="list" href="#local_pickup" role="tab" aria-controls="local_pickup">@lang('file.Local Pickup')</a>
                            <a class="list-group-item list-group-item-action" id="flat_rate-shipping_methods" data-toggle="list" href="#flat_rate" role="tab" aria-controls="flat_rate">@lang('file.Flat Rate')</a>
                        </div>
                    </div>
                </div>
             </div>

             <!-- Payment Methods  -->
             <div class="card">
                <div class="card-header" id="paymentMethod">
                    <div class="btn" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapseFour">
                        <h5 class="text-bold"><i class="fa fa-angle-right"></i>@lang('file.Payment Methods')</h5>
                    </div>
                </div>
                <div id="collapse4" class="collapse" aria-labelledby="paymentMethod" data-parent="#accordion">
                    <div class="card-body">
                        <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action" id="paypal-payment_methods" data-toggle="list" href="#paypal" role="tab" aria-controls="paypal">@lang('file.Paypal')</a>
                            <a class="list-group-item list-group-item-action" id="strip-payment_methods" data-toggle="list" href="#strip" role="tab" aria-controls="strip">@lang('file.Strip')</a>
                            <a class="list-group-item list-group-item-action" id="sslcommerz-payment_methods" data-toggle="list" href="#sslcommerz" role="tab" aria-controls="sslcommerz">@lang('file.SSL Commerz')</a>
                            <a class="list-group-item list-group-item-action" id="cash_on_delivery-payment_methods" data-toggle="list" href="#cash_on_delivery" role="tab" aria-controls="cash_on_delivery">@lang('file.Cash On Delivery')</a>
                            <a class="list-group-item list-group-item-action" id="razorpay-payment_methods" data-toggle="list" href="#razorpay" role="tab" aria-controls="razorpay">@lang('file.Razorpay')</a>
                            <a class="list-group-item list-group-item-action" id="paystack-payment_methods" data-toggle="list" href="#paystack" role="tab" aria-controls="paystack">@lang('file.Paystack')</a>
                        </div>
                    </div>
                </div>
             </div>
        </div>


            </div>
            <div class="col-8">
              <div class="tab-content" id="nav-tabContent">

                    <!----------------------------------- General Setting ------------------------------------------>

                    <!-- general -->
                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-settings">
                        @include('admin.pages.setting.general_setting.general')
                    </div>

                    <!-- Maintenance -->
                    <div class="tab-pane fade" id="maintenance" role="tabpanel" aria-labelledby="maintenance-settings">
                        @include('admin.pages.setting.general_setting.maintenance')
                    </div>

                    <!-- Stor-Contact -->
                    <div class="tab-pane fade" id="store" role="tabpanel" aria-labelledby="store-settings">
                        @include('admin.pages.setting.general_setting.store')
                    </div>

                    <!-- About Us -->
                    <div class="tab-pane fade" id="about-us" role="tabpanel" aria-labelledby="about-us-settings">
                        @include('admin.pages.setting.general_setting.about_us')
                    </div>

                    <!-- Currency -->
                    <div class="tab-pane fade" id="currency" role="tabpanel" aria-labelledby="currency-settings">
                        @include('admin.pages.setting.general_setting.currency')
                    </div>

                    <!-- SMS -->
                    <div class="tab-pane fade" id="sms" role="tabpanel" aria-labelledby="sms-settings">
                        @include('admin.pages.setting.general_setting.sms')
                    </div>

                    <!-- Mail -->
                    <div class="tab-pane fade" id="mail" role="tabpanel" aria-labelledby="mail-settings">
                        @include('admin.pages.setting.general_setting.mail')
                    </div>

                    <!-- Newsletter -->
                    <div class="tab-pane fade" id="newsletter" role="tabpanel" aria-labelledby="newsletter-settings">
                        @include('admin.pages.setting.general_setting.newsletter')
                    </div>

                    <!-- Custom CSS/Js -->
                    <div class="tab-pane fade" id="customCssJss" role="tabpanel" aria-labelledby="custom_css_jss-settings">
                        @include('admin.pages.setting.general_setting.custom_css_jss')
                    </div>

                    <!-- Custom CSS/Js -->
                    <div class="tab-pane fade" id="emptyDatabase" role="tabpanel" aria-labelledby="emptyDatabase-settings">
                        @include('admin.pages.setting.general_setting.empty_database')
                    </div>

                    <!----------------------------------- Social Login ------------------------------------------>

                    <!-- Facebook -->
                    <div class="tab-pane fade" id="facebook" role="tabpanel" aria-labelledby="facebook-social_login">
                        @include('admin.pages.setting.social_login.facebook')
                    </div>

                    <!-- Google -->
                    <div class="tab-pane fade" id="google" role="tabpanel" aria-labelledby="google-social_login">
                        @include('admin.pages.setting.social_login.google')
                    </div>

                    <!-- Github -->
                    <div class="tab-pane fade" id="github" role="tabpanel" aria-labelledby="github-social_login">
                        @include('admin.pages.setting.social_login.github')
                    </div>

                    <!----------------------------------- Shipping Methods ------------------------------------------>

                    <!-- Free Shipping -->
                    <div class="tab-pane fade" id="free_shipping" role="tabpanel" aria-labelledby="free_shipping-shipping_methods">
                        @include('admin.pages.setting.shipping_method.free_shipping')
                    </div>

                    <!-- Local Pickup -->
                    <div class="tab-pane fade" id="local_pickup" role="tabpanel" aria-labelledby="local_pickup-shipping_methods">
                        @include('admin.pages.setting.shipping_method.local_pickup')
                    </div>

                    <!-- Flat Rate -->
                    <div class="tab-pane fade" id="flat_rate" role="tabpanel" aria-labelledby="flat_rate-shipping_methods">
                        @include('admin.pages.setting.shipping_method.flat_rate')
                    </div>

                    <!----------------------------------- Payment Methods ------------------------------------------>

                    <!-- Paypal  -->
                    <div class="tab-pane fade" id="paypal" role="tabpanel" aria-labelledby="paypal-payment_methods">
                        @include('admin.pages.setting.payment_method.paypal')
                    </div>

                    <!-- Strip  -->
                    <div class="tab-pane fade" id="strip" role="tabpanel" aria-labelledby="strip-payment_methods">
                        @include('admin.pages.setting.payment_method.strip')
                    </div>

                    <!-- SSL Commerz  -->
                    <div class="tab-pane fade" id="sslcommerz" role="tabpanel" aria-labelledby="sslcommerz-payment_methods">
                        @include('admin.pages.setting.payment_method.sslcommerz')
                    </div>

                    <!-- Paytm  -->
                    <div class="tab-pane fade" id="paytm" role="tabpanel" aria-labelledby="paytm-payment_methods">
                        @include('admin.pages.setting.payment_method.paytm')
                    </div>

                    <!-- Cash On Delivery  -->
                    <div class="tab-pane fade" id="cash_on_delivery" role="tabpanel" aria-labelledby="cash_on_delivery-payment_methods">
                        @include('admin.pages.setting.payment_method.cash_on_delivery')
                    </div>

                    <!-- Bank Transfer  -->
                    <div class="tab-pane fade" id="bank_transfer" role="tabpanel" aria-labelledby="bank_transfer-payment_methods">
                        @include('admin.pages.setting.payment_method.bank_transfer')
                    </div>

                    <!-- Check / Money Order  -->
                    <div class="tab-pane fade" id="check_money_order" role="tabpanel" aria-labelledby="check_money_order-payment_methods">
                        @include('admin.pages.setting.payment_method.check_money_order')
                    </div>

                    <!-- Razorpay  -->
                    <div class="tab-pane fade" id="razorpay" role="tabpanel" aria-labelledby="razorpay-payment_methods">
                        @include('admin.pages.setting.payment_method.razorpay')
                    </div>

                    <!-- Paystack  -->
                    <div class="tab-pane fade" id="paystack" role="tabpanel" aria-labelledby="paystack-payment_methods">
                        @include('admin.pages.setting.payment_method.paystack')
                    </div>
              </div>
            </div>
          </div>
</div>
@endsection


@push('scripts')
    <script type="text/javascript">
        (function ($) {
            "use strict";

                //----------Insert Data----------------------

                //General
                $('#generalSubmit').on('submit', function (e) {
                    @include('admin.includes.common_js.setting_submit_js',['route_name'=>'admin.setting.general.store_or_update'])
                });

                //Store
                $('#storeSubmit').on('submit', function (e) {
                    @include('admin.includes.common_js.setting_submit_js',['route_name'=>'admin.setting.store.store_or_update'])
                });

                //About Us
                $('#aboutUsSubmit').on('submit', function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.setting.about_us.store_or_update')}}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            let html = '';
                            if (data.errors) {
                                html = '<div class="alert alert-danger">';
                                for (let count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                                $('#alert_message').fadeIn("slow");
                                $('#alert_message').html(html);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                            else if(data.success){
                                $('#alert_message').fadeIn("slow"); //Check in top in this blade
                                $('#alert_message').addClass('alert alert-success').html(data.success);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                        }
                    });
                });


                //Currency - exchange rate service
                $('#exchangeRateService').change(function() {
                    var exchangeRateService = $('#exchangeRateService').val();

                    if (exchangeRateService=="fixer") {
                        data = '<label class="col-sm-4 col-form-label"><b> {{__('Fixer Access Key')}} &nbsp;<span class="text-danger">*</span> </b></label>';
                        data += '<div class="col-sm-8">';
                        data += '<input type="text" name="fixer_access_key" class="form-control">';
                        data += '</div>';
                        $('#exchangeRateServiceField').html(data);
                    }
                    else if (exchangeRateService=="forge") {
                        data = '<label class="col-sm-4 col-form-label"><b> {{__('Forge API Key')}} &nbsp;<span class="text-danger">*</span> </b></label>';
                        data += '<div class="col-sm-8">';
                        data += '<input type="text" name="forge_api_key" class="form-control">';
                        data += '</div>';
                        $('#exchangeRateServiceField').html(data);
                    }
                    else if (exchangeRateService=="currency_data_feed") {
                        data = '<label class="col-sm-4 col-form-label"><b> {{__('Currency Data Feed API Key')}} &nbsp;<span class="text-danger">*</span> </b></label>';
                        data += '<div class="col-sm-8">';
                        data += '<input type="text" name="currency_data_feed_key" class="form-control">';
                        data += '</div>';
                        $('#exchangeRateServiceField').html(data);
                    }else{
                        $('#exchangeRateServiceField').empty();
                    }
                });


                //Currency Submit
                $('#currencySubmit').on('submit', function (e) {
                    e.preventDefault();

                    $.ajax({
                        url: "{{route('admin.setting.currency.store_or_update')}}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            let html = '';

                            if (data.errors) {
                                html = '<div class="alert alert-danger">';
                                for (let count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                                $('#alert_message').fadeIn("slow");
                                $('#alert_message').html(html);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                            else if (data.error_exchange_rate_service) {
                                html = '<div class="alert alert-danger">';
                                html += '<p>' + data.error_exchange_rate_service + '</p>';
                                html += '</div>';
                                $('#alert_message').fadeIn("slow");
                                $('#alert_message').html(html);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                            else if(data.selectionError){
                                $('#alert_message').fadeIn("slow"); //Check in top in this blade
                                $('#alert_message').addClass('alert alert-danger').html(data.selectionError);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                            else if(data.success){
                                $('#alert_message').fadeIn("slow"); //Check in top in this blade
                                $('#alert_message').addClass('alert alert-success').html(data.success);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                        }
                    });
                });


                //SMS Service - Change SMS Service
                $('#smsService').change(function() {
                    var smsService = $('#smsService').val();

                    if (smsService=="vonage") {
                        data1 = '<label class="col-sm-4 col-form-label"><b> {{__('API Key')}} &nbsp;<span class="text-danger">*</span> </b></label>';
                        data1 += '<div class="col-sm-8">';
                        data1 += '<input type="text" name="api_key" class="form-control">';
                        data1 += '</div>';
                        $('#vonageApiKeyField').html(data1);


                        data2 = '<label class="col-sm-4 col-form-label"><b> {{__('API Secret')}} &nbsp;<span class="text-danger">*</span> </b></label>';
                        data2 += '<div class="col-sm-8">';
                        data2 += '<input type="text" name="api_secret" class="form-control">';
                        data2 += '</div>';
                        $('#vonageApiSecretField').html(data2);

                        $('#twilioAccountSidField').empty();
                        $('#twilioAuthTokenField').empty();
                    }
                    else if (smsService=="twilio") {
                        data3 = '<label class="col-sm-4 col-form-label"><b> {{__('Account SID')}} &nbsp;<span class="text-danger">*</span> </b></label>';
                        data3 += '<div class="col-sm-8">';
                        data3 += '<input type="text" name="account_sid" class="form-control">';
                        data3 += '</div>';
                        $('#twilioAccountSidField').html(data3);


                        data4 = '<label class="col-sm-4 col-form-label"><b> {{__('Auth Token')}} &nbsp;<span class="text-danger">*</span> </b></label>';
                        data4 += '<div class="col-sm-8">';
                        data4 += '<input type="text" name="auth_token" class="form-control">';
                        data4 += '</div>';
                        $('#twilioAuthTokenField').html(data4);

                        $('#vonageApiKeyField').empty();
                        $('#vonageApiSecretField').empty();
                    }else{
                        $('#vonageApiKeyField').empty();
                        $('#vonageApiSecretField').empty();
                        $('#twilioAccountSidField').empty();
                        $('#twilioAuthTokenField').empty();
                    }
                });

                //SMS Submit
                $('#smsSubmit').on('submit', function (e) {
                    e.preventDefault();

                    $.ajax({
                        url: "{{route('admin.setting.sms.store_or_update')}}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            let html = '';

                            if (data.errors) {
                                html = '<div class="alert alert-danger">';
                                for (let count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                                $('#alert_message').fadeIn("slow");
                                $('#alert_message').html(html);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                            else if (data.error_sms_service) {
                                html = '<div class="alert alert-danger">';
                                html += '<p>' + data.error_sms_service + '</p>';
                                html += '</div>';
                                $('#alert_message').fadeIn("slow");
                                $('#alert_message').html(html);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                            else if(data.success){
                                $('#alert_message').fadeIn("slow"); //Check in top in this blade
                                $('#alert_message').addClass('alert alert-success').html(data.success);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                        }
                    });
                });


                //Mail Submit
                $('#mailSubmit').on('submit', function (e) {
                    @include('admin.includes.common_js.setting_submit_js',['route_name'=>'admin.setting.mail.store_or_update'])
                });


                //Newletter Submit
                $('#newletterSubmit').on('submit', function (e) {
                    @include('admin.includes.common_js.setting_submit_js',['route_name'=>'admin.setting.newsletter.store_or_update'])
                });


                //custom css/js Submit
                $('#customCssJssSubmit').on('submit', function (e) {
                    e.preventDefault();

                    $.ajax({
                        url: "{{route('admin.setting.custom_css_js.store_or_update')}}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            let html = '';
                            if(data.success){
                                $('#alert_message').fadeIn("slow"); //Check in top in this blade
                                $('#alert_message').addClass('alert alert-success').html(data.success);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                        }
                    });
                });

                //Facebook
                $('#facebookSubmit').on('submit', function (e) {
                    @include('admin.includes.common_js.setting_submit_js',['route_name'=>'admin.setting.facebook.store_or_update'])
                });

                //Google
                $('#googleSubmit').on('submit', function (e) {
                    @include('admin.includes.common_js.setting_submit_js',['route_name'=>'admin.setting.google.store_or_update'])
                });

                //Google
                $('#githubSubmit').on('submit', function (e) {
                    @include('admin.includes.common_js.setting_submit_js',['route_name'=>'admin.setting.github.store_or_update'])
                });


                //free Shipping Submit
                $('#freeShippingSubmit').on('submit', function (e) {
                    @include('admin.includes.common_js.setting_submit_js',['route_name'=>'admin.setting.free_shipping.store_or_update'])
                });

                //local pickup Submit
                $('#localPickupSubmit').on('submit', function (e) {
                    @include('admin.includes.common_js.setting_submit_js',['route_name'=>'admin.setting.local_pickup.store_or_update'])
                });


                //Flat Rate
                $('#flatRateSubmit').on('submit', function (e) {
                    @include('admin.includes.common_js.setting_submit_js',['route_name'=>'admin.setting.flat_rate.store_or_update'])
                });

                //Paypal
                $('#paypalSubmit').on('submit', function (e) {
                    @include('admin.includes.common_js.setting_submit_js',['route_name'=>'admin.setting.paypal.store_or_update'])
                });

                //Strip
                $('#stripSubmit').on('submit', function (e) {
                    @include('admin.includes.common_js.setting_submit_js',['route_name'=>'admin.setting.strip.store_or_update'])
                });

                //SSL Commerz
                $('#sslComerzSubmit').on('submit', function (e) {
                    @include('admin.includes.common_js.setting_submit_js',['route_name'=>'admin.setting.sslcommerz.store_or_update'])
                });


                //Cash On Delivery
                $('#cashOnDeliverySubmit').on('submit', function (e) {
                    @include('admin.includes.common_js.setting_submit_js',['route_name'=>'admin.setting.cash_on_delivery.store_or_update'])
                });

                //Razorpay
                $('#razorpaySubmit').on('submit', function (e) {
                    @include('admin.includes.common_js.setting_submit_js',['route_name'=>'admin.setting.razorpay.store_or_update'])
                });

                //Paystack
                $("#paystackSubmit").on('submit', function (e) {
                    @include('admin.includes.common_js.setting_submit_js',['route_name'=>'admin.setting.paystack.store_or_update'])
                });


                //Paytm
                $('#paytmSubmit').on('submit', function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.setting.paytm.store_or_update')}}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            let html = '';
                            if (data.errors) {
                                html = '<div class="alert alert-danger">';
                                for (let count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                                $('#alert_message').fadeIn("slow");
                                $('#alert_message').html(html);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                            else if(data.success){
                                $('#alert_message').fadeIn("slow"); //Check in top in this blade
                                $('#alert_message').addClass('alert alert-success').html(data.success);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                        }
                    });
                });

                //Bank Transfer
                $('#bankTransferSubmit').on('submit', function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.setting.bank_transfer.store_or_update')}}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            let html = '';
                            if (data.errors) {
                                html = '<div class="alert alert-danger">';
                                for (let count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                                $('#alert_message').fadeIn("slow");
                                $('#alert_message').html(html);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                            else if(data.success){
                                $('#alert_message').fadeIn("slow"); //Check in top in this blade
                                $('#alert_message').addClass('alert alert-success').html(data.success);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                        }
                    });
                });

                //Check Money / Order
                $('#checkMoneyOrderSubmit').on('submit', function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.setting.check_money_order.store_or_update')}}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            let html = '';
                            if (data.errors) {
                                html = '<div class="alert alert-danger">';
                                for (let count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                                $('#alert_message').fadeIn("slow");
                                $('#alert_message').html(html);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                            else if(data.success){
                                $('#alert_message').fadeIn("slow"); //Check in top in this blade
                                $('#alert_message').addClass('alert alert-success').html(data.success);
                                setTimeout(function() {
                                    $('#alert_message').fadeOut("slow");
                                }, 3000);
                            }
                        }
                    });
                });


            // $('#supportedCurrencies').change(function (e) {
            //     var test = $('#supportedCurrencies').val();
            //     console.log(test[0]);
            // });

            })(jQuery);
    </script>
@endpush

