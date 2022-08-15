@extends('frontend.layouts.master')
@section('title','Search Products')

@section('frontend_content')
    <!--Breadcrumb Area start-->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <ul>
                        <li><a href="{{route('cartpro.home')}}">@lang('file.Home')</a></li>
                        <li class="active">@lang('file.Search Produtcs')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb Area ends-->
    <!-- Shop Page Starts-->
    <div class="shop-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        @forelse ($products as $item)
                            <!--Shop product wrapper starts-->
                            <div class="col shop-products-wrapper">
                                <div class="product-grid">
                                    <div class="product-grid-item">

                                        <form action="{{route('product.add_to_cart')}}" class="addToCart" method="post">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{$item->product->id}}">
                                            <input type="hidden" name="product_slug" value="{{$item->product->slug}}">
                                            <input type="hidden" name="category_id" value="{{$item->product->categoryProduct[0]->category_id}}">
                                            <input type="hidden" name="qty" value="1">

                                            <div class="single-product-wrapper">
                                                <div class="single-product-item">
                                                    @if (isset($item->product->baseImage->image_medium) && Illuminate\Support\Facades\File::exists(public_path($item->product->baseImage->image_medium)))
                                                        <a href="{{url('product/'.$item->product->slug.'/'. $item->product->categoryProduct[0]->category_id)}}"><img class="lazy" data-src="{{asset('public/'.$item->product->baseImage->image_medium)}}"></a>
                                                    @else
                                                        <a href="{{url('product/'.$item->product->slug.'/'. $item->product->categoryProduct[0]->category_id)}}"><img src="https://dummyimage.com/221x221/e5e8ec/e5e8ec&text=CartPro"></a>
                                                    @endif

                                                    @if (($item->product->manage_stock==1 && $item->product->qty==0) || ($item->product->in_stock==0))
                                                        <div class="product-promo-text style1">
                                                            <span>@lang('file.Stock Out')</span>
                                                        </div>
                                                    @endif

                                                    <div class="product-overlay">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#id_{{$item->product->id}}"> <span class="ti-zoom-in" data-bs-toggle="tooltip" data-bs-placement="top" title="quick view"></span></a>
                                                        <a><span class="ti-heart @auth add_to_wishlist @else forbidden_wishlist @endauth" class="ti-heart"  data-product_id="{{$item->product->id}}" data-product_slug="{{$item->product->slug}}" data-category_id="{{$item->product->categoryProduct[0]->category_id}}" data-qty="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist"></span></a>
                                                    </div>
                                                </div>
                                                <div class="product-details">
                                                    <a class="product-name" href="{{url('product/'.$item->product->slug.'/'. $item->product->categoryProduct[0]->category_id)}}">
                                                        {{$item->product_name}}
                                                    </a>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <div class="rating-summary">
                                                                <div class="rating-result" title="60%">
                                                                    <ul class="product-rating">
                                                                        @php
                                                                            for ($i=1; $i <=5 ; $i++){
                                                                                if ($i<= round($item->product->avg_rating)){
                                                                        @endphp
                                                                                    <li><i class="las la-star"></i></li>
                                                                        @php
                                                                                }else {
                                                                        @endphp
                                                                                    <li><i class="lar la-star"></i></li>
                                                                        @php        }
                                                                            }
                                                                        @endphp
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="product-price">
                                                                @if ($item->special_price>0)
                                                                    <span class="promo-price">
                                                                        @if(env('CURRENCY_FORMAT')=='suffix')
                                                                            {{ number_format((float)$item->product->special_price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                                        @else
                                                                            @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->special_price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                                        @endif
                                                                    </span>
                                                                    <span class="old-price">
                                                                        @if(env('CURRENCY_FORMAT')=='suffix')
                                                                            {{ number_format((float)$item->product->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                                        @else
                                                                            @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                                        @endif
                                                                    </span>
                                                                @else
                                                                    <span class="price">
                                                                        @if(env('CURRENCY_FORMAT')=='suffix')
                                                                            {{ number_format((float)$item->product->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                                        @else
                                                                            @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                                        @endif
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div>
                                                            @if (($item->product->manage_stock==1 && $item->product->qty==0) || ($item->product->in_stock==0))
                                                                <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="Disabled"><button class="btn button style2 sm" disabled><i class="las la-cart-plus"></i></button></span>
                                                            @else
                                                                <button class="button style2 sm" type="submit" data-bs-toggle="tooltip" data-bs-placement="top"><i class="las la-cart-plus"></i></button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Page Ends-->

    <!-- Quick Shop Modal starts -->
    @forelse ($products as $item)
        @include('frontend.includes.quickshop_search')
    @empty
    @endforelse
@endsection

