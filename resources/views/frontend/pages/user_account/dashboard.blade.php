@extends('frontend.layouts.master')
@section('frontend_content')
    <!--Breadcrumb Area start-->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="page-title">@lang('file.My Account')</h1>
                    <ul>
                        <li><a href="home.html">@lang('file.Home')</a></li>
                        <li class="active">@lang('file.My Account')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb Area ends-->

    @include('frontend.includes.alert_message')

    <!--My account Dashboard starts-->
    <section class="my-account-section">
        <div class="container">
            <div class="row">

                <!-- Profile Common -->
                @include('frontend.pages.user_account.profile_common')


                <div class="col-md-9 tabs style1">
                    <div class="row">

                        <!-- Tab -->
                        @include('frontend.pages.user_account.tab_common')

                        <div class="col-md-12 mar-top-30">
                            <div class="user-dashboard-tab__content tab-content">
                                <div class="tab-pane fade mt-3 show active" id="dashboard" role="tabpanel">
                                    <p>@lang('file.Hello') <strong>{{Auth::user()->first_name.' '.Auth::user()->last_name}}</strong>,</p>
                                    <p>@lang('file.From your account dashboard you can easily check & view your recent orders, manage your shipping and billing addresses and edit your password and account details.')</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--My account Dashboard ends-->
@endsection
