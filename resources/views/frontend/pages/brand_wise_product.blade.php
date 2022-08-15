@extends('frontend.layouts.master')

@section('title','Brand Wise Product')

@section('frontend_content')

    <!--Breadcrumb Area start-->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <ul>
                        <li><a href="{{route('cartpro.home')}}">@lang('file.Home')</a></li>
                        <li class="active">@lang('file.Brand')</li>
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
                    <div class="col-lg-9">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="page-title h5 uppercase mb-0">{{$brand->brand_name}}</h1>
                            <span class="d-none d-md-block"><strong class="theme-color">{{count($products)}}</strong> @lang('file.Products Found')</span>
                        </div>
                        <div class="row">
                            @forelse ($products as $item)

                                <!--Shop product wrapper starts-->
                                <div class="col shop-products-wrapper">
                                    <div class="product-grid">
                                        <div class="product-grid-item">

                                            <form action="{{route('product.add_to_cart')}}" class="addToCart" method="post">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{$item->id}}">
                                                <input type="hidden" name="product_slug" value="{{$item->slug}}">
                                                <input type="hidden" name="category_id" value="{{$category_ids[$item->id]->category_id}}">
                                                <input type="hidden" name="qty" value="1">

                                                <div class="single-product-wrapper">
                                                    <div class="single-product-item">
                                                        @if (isset($item->image_medium) && Illuminate\Support\Facades\File::exists(public_path($item->image_medium)))
                                                            <a href="{{url('product/'.$item->slug.'/'. $category_ids[$item->id]->category_id)}}"><img class="lazy" data-src="{{asset('public/'.$item->image_medium)}}"></a>
                                                        @else
                                                            <a href="{{url('product/'.$item->slug.'/'. $category_ids[$item->id]->category_id)}}"><img src="https://dummyimage.com/221x221/e5e8ec/e5e8ec&text=CartPro"></a>
                                                        @endif

                                                        <!-- product-promo-text -->
                                                        @include('frontend.includes.product-promo-text',['manage_stock'=>$item->manage_stock, 'qty'=>$item->qty, 'in_stock'=>$item->in_stock, 'in_stock'=>$item->in_stock, 'current_date'=>date('Y-m-d') ,'new_to'=>$item->new_to])
                                                        <!--/ product-promo-text -->

                                                        <div class="product-overlay">
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#id_{{$item->id}}"> <span class="ti-zoom-in" data-bs-toggle="tooltip" data-bs-placement="top" title="quick view"></span></a>
                                                            <a><span class="ti-heart @auth add_to_wishlist @else forbidden_wishlist @endauth" class="ti-heart"  data-product_id="{{$item->id}}" data-product_slug="{{$item->slug}}" data-category_id="{{$category_ids[$item->id]->category_id}}" data-qty="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist"></span></a>
                                                        </div>
                                                    </div>
                                                    <div class="product-details">
                                                        <a class="product-name" href="{{url('product/'.$item->slug.'/'. $category_ids[$item->id]->category_id)}}">
                                                            {{$item->product_name}}
                                                        </a>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <div class="rating-summary">
                                                                    <div class="rating-result" title="60%">
                                                                        <ul class="product-rating">
                                                                            @php
                                                                                for ($i=1; $i <=5 ; $i++){
                                                                                    if ($i<= round($item->avg_rating)){  @endphp
                                                                                        <li><i class="las la-star"></i></li>
                                                                            @php
                                                                                    }else { @endphp
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
                                                                                {{ number_format((float)$item->special_price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                                            @else
                                                                                @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->special_price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                                            @endif
                                                                        </span>
                                                                        <span class="old-price">
                                                                            @if(env('CURRENCY_FORMAT')=='suffix')
                                                                                {{ number_format((float)$item->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                                            @else
                                                                                @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                                            @endif
                                                                        </span>
                                                                    @else
                                                                        <span class="price">
                                                                            @if(env('CURRENCY_FORMAT')=='suffix')
                                                                                {{ number_format((float)$item->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                                            @else
                                                                                @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                                            @endif
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div>
                                                                @if (($item->manage_stock==1 && $item->qty==0) || ($item->in_stock==0))
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


        @forelse ($products as $item)
            @include('frontend.includes.quickshop_brand')
        @empty
        @endforelse
@endsection


@push('scripts')
    <script type="text/javascript">


        $('.attribute_value_productTab1').on("click",function(e){
            e.preventDefault();
            $(this).addClass('selected');

            var selectedVal = $(this).data('value_id');
            values.push(selectedVal);
            $('.value_ids_brand').val(values);
        });
    </script>
@endpush
