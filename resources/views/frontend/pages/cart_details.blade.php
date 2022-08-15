@extends('frontend.layouts.master')
@section('frontend_content')

<!--Breadcrumb Area start-->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col">
                <ul>
                    <li><a href="home.html">@lang('file.Home')</a></li>
                    <li class="active">@lang('file.Shop Cart')</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--Breadcrumb Area ends-->



    <!--Shop cart starts-->
    <section class="shop-cart-section pt-0 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    @if (count($cart_content)>0)
                        <h1 class="page-title h2 mt-1 mb-5">{{__('file.Your Cart')}}</h1>
                    @else
                        <img src="{{asset('public/frontend/images/empty-cart.png')}}" alt="Empty cart"/>
                        <h1 class="page-title h2 mt-1 mb-5">{{__('file.Your cart is currently empty')}}</h1>
                        <a class="button style1" href="{{url('/')}}">{{ __('Continue Shopping') }}</a>
                    @endif

                </div>
                @if (count($cart_content)>0)
                    <div class="col-lg-8">
                        <div class="table-content table-responsive cart-table">
                            <table class="table" >
                                <thead>
                                    <tr>
                                        <th>@lang('file.Product')</th>
                                        <th class="text-center">@lang('file.Total')</th>
                                    </tr>
                                </thead>
                                <tbody class="cartTable">

                                    <div id="content">
                                        @forelse ($cart_content as $item)
                                            <tr id="{{$item->rowId}}" class="{{$item->rowId}}">
                                                <td class="cart-product">
                                                    <div class="item-details">
                                                        <a class="remove_cart_from_details" data-id="{{$item->rowId}}" title="Remove this item"><i class="ti-close"></i></a>
                                                        <img class="lazy" data-src="{{asset('public/'.$item->options->image ?? null)}}" alt="...">
                                                        <div class="">
                                                            <a href="{{url('product/'.$item->options->product_slug.'/'. $item->options->category_id)}}">
                                                                <h3 class="h6">{{$item->name}}</h3>
                                                            </a>
                                                            <div class="input-qty">
                                                                <form class="quantity_change_submit" data-id="{{$item->rowId}}" method="get">
                                                                    <span class="input-group-btn">
                                                                        <button type="submit" class="quantity-left-minus quantity_change" data-id="{{$item->rowId}}">
                                                                            <span class="ti-minus"></span>
                                                                        </button>
                                                                    </span>
                                                                    @if (($item->options->manage_stock==1 && $item->options->stock_qty==0) || ($item->options->in_stock==0))
                                                                        <input type="number" readonly name="qty" class="input-number qty_{{$item->rowId}}" value="{{$item->qty}}" min="1" max="0">
                                                                    @else
                                                                        <input type="number" readonly name="qty" class="input-number qty_{{$item->rowId}}" value="{{$item->qty}}" min="1" max="{{$item->options->stock_qty}}">
                                                                    @endif
                                                                    <span class="input-group-btn">
                                                                        <button type="submit" class="quantity-right-plus quantity_change" data-id="{{$item->rowId}}">
                                                                            <span class="ti-plus"></span>
                                                                        </button>
                                                                    </span>
                                                                </form>
                                                            </div>
                                                            X
                                                            <span class="amount">
                                                                @if(env('CURRENCY_FORMAT')=='suffix')
                                                                    {{number_format((float)$item->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '')}} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                                @else
                                                                    @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{number_format((float)$item->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '')}}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="cart-product-subtotal">
                                                    <span class="amount">
                                                        @if(env('CURRENCY_FORMAT')=='suffix')
                                                            {{-- <span class="subtotal_{{$item->rowId}}">{{$item->subtotal}}</span> {{env('DEFAULT_CURRENCY_SYMBOL')}} --}}
                                                            <span class="subtotal_{{$item->rowId}}">{{number_format((float)$item->subtotal * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '')}}</span> @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                        @else
                                                            @include('frontend.includes.SHOW_CURRENCY_SYMBOL') <span class="subtotal_{{$item->rowId}}">{{number_format((float)$item->subtotal * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '')}}</span>
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </div>
                                </tbody>
                            </table>

                            <a href="{{route('cartpro.home')}}" class="button style3"><i class="ti-arrow-left"></i> @lang('file.Continue Shopping')</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="cart-subtotal">
                            <div class="total">
                                <div class="label">{{__('file.Total')}}</div>
                                <div class="price">
                                    @if(env('CURRENCY_FORMAT')=='suffix')
                                        <span class="total_price">{{number_format((float)$cart_total * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '')}}</span> @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                    @else
                                        @include('frontend.includes.SHOW_CURRENCY_SYMBOL') <span class="total_price">{{number_format((float)$cart_total * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '')}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <a class="button lg style1 d-block text-center" href="{{route('cart.checkout')}}">@lang('file.Proceed to Checkout')</a>
                    </div>
                @endif
            </div>

        </div>
    </section>
    <!--Shop cart ends-->

@endsection

@push('scripts')
<script>
    (function ($) {
        "use strict";


        $(".quantity-left-minus").on("click",function(e){
            $(".quantity-right-plus").prop("disabled",false);
        });

        $(".quantity-right-plus").on("click",function(e){
            var inputNumber = $('.input-number').val();
            var maxNumber = $('.input-number').attr('max');
            if (maxNumber==0) {
                console.log(Number(maxNumber));
            }else{
                if ((Number(inputNumber)+1) > Number(maxNumber)) {
                    $('.input-number').val(Number(maxNumber)-1);
                    $(this).prop("disabled",true);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Available product is : '+ maxNumber,
                    });
                }
            }
        });

        $('.quantity_change_submit').on("click",function(e){
            e.preventDefault();
            var rowId = $(this).data('id');
            var input_number = $('.qty_'+rowId).val();
            $.ajax({
                url: "{{ route('cart.quantity_change') }}",
                type: "GET",
                data: {rowId:rowId,qty:input_number},
                success: function (data) {
                    console.log(data)
                    if (data.type=='success') {
                        $('.subtotal_'+rowId).text(data.cartSpecificSubtotal);
                        $('.cart_count').text(data.cartCount);
                        $('.my_cart_specific_qty_'+rowId).text(data.cartSpecificCount);
                        $('.total_price').text(data.cartTotal);
                        $('.cart_total').text(data.cartTotal);
                    }
                }
            })
        });

        $(document).on('click','.remove_cart_from_details',function(event) {
            event.preventDefault();
            var rowId = $(this).data('id');
            var removeCartItemFromDetails = $(this).closest('tr');
            $.ajax({
                url: "{{ route('cart.remove') }}",
                type: "GET",
                data: {rowId:rowId},
                success: function (data) {
                    if (data.type=='success') {
                        let amountConvertToCurrency = parseFloat(data.cart_total) * {{$CHANGE_CURRENCY_RATE}};
                        removeCartItemFromDetails.remove();
                        $('#'+rowId).remove();
                        $('.cart_count').text(data.cart_count);
                        $('.cart_total').text(amountConvertToCurrency.toFixed(2));
                        $('.total_price').text(amountConvertToCurrency.toFixed(2));
                    }
                }
            })
        });

    })(jQuery);
</script>
@endpush

