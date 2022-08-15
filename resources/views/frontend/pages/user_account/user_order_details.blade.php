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

                        <div class="table-content table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="plantmore-product-thumbnail">@lang('file.Images')</th>
                                        <th class="cart-product-name">@lang('file.Product')</th>
                                        <th class="plantmore-product-price">@lang('file.Unit Price')</th>
                                        <th class="plantmore-product-quantity">@lang('file.Quantity')</th>
                                        <th class="plantmore-product-subtotal">@lang('file.Subtotal')</th>
                                        <th class="plantmore-product-subtotal">@lang('file.Attribute Details')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_quantity = 0;
                                        $total_subtotal = 0;
                                    @endphp
                                    @foreach ($order_details as $item)
                                        @php
                                            $total_quantity += $item->qty;
                                            $total_subtotal += $item->subtotal
                                        @endphp

                                        <tr>
                                            <td class="plantmore-product-thumbnail">
                                                <img src="{{asset('public/'.$item->image)}}" style="width:90px;height:90px">
                                            </td>
                                            <td class="plantmore-product-name">{{$item->product_name}}</td>
                                            <td class="plantmore-product-price">
                                                <span class="amount">
                                                    @if(env('CURRENCY_FORMAT')=='suffix')
                                                        {{ number_format((float)$item->price  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                    @else
                                                        @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="plantmore-product-quantity">
                                                <div class="input-qty">
                                                    <input type="text" readonly class="input-number" value="{{ $item->qty }}">
                                                </div>
                                            </td>
                                            <td class="product-subtotal">
                                                <span class="amount">
                                                    @if(env('CURRENCY_FORMAT')=='suffix')
                                                        {{ number_format((float)$item->subtotal  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                    @else
                                                        @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->subtotal * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="plantmore-product-name">
                                                @php
                                                    $attributes = json_decode($item->options);
                                                @endphp
                                                @forelse ($attributes as $key => $item)
                                                    @if ($key!='image' && $key!='product_slug' && $key!='category_id' && $key!= 'manage_stock' && $key!='stock_qty' && $key!='in_stock' && $key!='brand_id')
                                                        <p><b>{{$key}}</b> :{{$item}}</p>
                                                    @endif
                                                @empty
                                                    <p>NONE</p>
                                                @endforelse
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <p><i class="fw-bold"><b>@lang('file.Total Quantity')</b></i></p>
                                            <p>{{$total_quantity}}</p>
                                        </td>
                                        <td>
                                            <p><i class="fw-bold"><b>@lang('file.Subtotal')</b></i></p>

                                            @if(env('CURRENCY_FORMAT')=='suffix')
                                                <p>{{ number_format((float)$total_subtotal  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')</p>
                                            @else
                                                <p>@include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$total_subtotal * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}</p>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table">
                                        <tr>
                                            <th><span contenteditable>@lang('file.Subtotal')</span></th>
                                            <td>
                                                <span contenteditable>
                                                    @if(env('CURRENCY_FORMAT')=='suffix')
                                                        {{ number_format((float)$total_subtotal  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                    @else
                                                        @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$total_subtotal * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><span contenteditable>@lang('file.Tax')</span></th>
                                            <td>
                                                <span contenteditable>
                                                    @if(env('CURRENCY_FORMAT')=='suffix')
                                                        {{ number_format((float)$order->tax  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                    @else
                                                        @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$order->tax * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><span contenteditable>@lang('file.Shipping Cost')</span></th>
                                            <td>
                                                <span contenteditable>
                                                    @if(env('CURRENCY_FORMAT')=='suffix')
                                                        {{ number_format((float)$order->shipping_cost  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                    @else
                                                        @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$order->shipping_cost * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><span contenteditable>@lang('file.Discount')</span></th>
                                            <td>
                                                <span contenteditable>
                                                    @if(env('CURRENCY_FORMAT')=='suffix')
                                                        {{ number_format((float)$order->discount  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                    @else
                                                        @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$order->discount * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th><span contenteditable><h6 class="text-success"><b>@lang('file.Total Amount')</b></h6></span></th>
                                            <td>
                                                <h6 class="text-success">
                                                    <b>
                                                        <span contenteditable>
                                                            @if(env('CURRENCY_FORMAT')=='suffix')
                                                                {{ number_format((float)$order->total  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                            @else
                                                                @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$order->total * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                            @endif
                                                        </span>
                                                    </b>
                                                </h6>
                                            </td>
                                        </tr>
                                    </table>

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
