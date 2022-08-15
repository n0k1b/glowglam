@extends('frontend.layouts.master')
@section('frontend_content')
    <!--Breadcrumb Area start-->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="page-title">@lang('file.Order History')</h1>
                    <ul>
                        <li><a href="home.html">@lang('file.Home')</a></li>
                        <li class="active">@lang('file.Order History')</li>
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

                        @forelse ($orders as $item)
                            <div class="card mb-5">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>@lang('file.Order ID') : {{$item->id}} </strong>
                                            <span class="d-block">{{date('d M, Y',strtotime($item->date))}}</span>
                                        </div>
                                        <div>
                                            <strong>Delivery Date</strong>
                                            <span class="d-block">@if($item->delivery_date){{date('d M, Y',strtotime($item->delivery_date))}}@else NONE @endif</span>
                                        </div>
                                        <div>
                                            <strong>Delivery Time</strong>
                                            <span class="d-block">{{$item->delivery_time ??'NONE'}}</span>
                                        </div>
                                        <div>
                                            @php
                                                $bg_color = '';
                                                if ($item->order_status=='order_placed') {
                                                    $bg_color = 'primary';
                                                }else if($item->order_status=='pending'){
                                                    $bg_color = 'danger';
                                                }else if($item->order_status=='order_confirmed'){
                                                    $bg_color = 'secondary';
                                                }else if($item->order_status=='delivery_scheduled'){
                                                    $bg_color = 'warning';
                                                }else if($item->order_status=='delivery_successful'){
                                                    $bg_color = 'info';
                                                }else if($item->order_status=='payment_successful'){
                                                    $bg_color = 'light';
                                                }else if($item->order_status=='order_completed'){
                                                    $bg_color = 'success';
                                                }
                                            @endphp
                                            <span class="p-2 badge rounded-pill bg-{{$bg_color}}">{{ucwords(str_replace('_', ' ',$item->order_status))}}</span>
                                        </div>
                                    </div>
                                    <hr class="mt-3 mb-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>
                                                @if(env('CURRENCY_FORMAT')=='suffix')
                                                    {{ number_format((float)$item->total  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                @else
                                                    @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->total * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                @endif
                                            </h4>
                                        </div>
                                        <div>
                                            <a class="btn btn-sm btn-success" href="{{route('user.order.history.details',$item->id)}}"><i class="ti-eye"></i></a> &nbsp;&nbsp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="card text-center">
                                <div class="card-body">
                                    <h1>@lang('file.You have no order right now')</h1>
                                </div>
                            </div>
                        @endforelse

                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--My account Dashboard ends-->
@endsection
