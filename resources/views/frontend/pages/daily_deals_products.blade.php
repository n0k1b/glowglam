@extends('frontend.layouts.master')
@section('title','Daily Deals')

@section('frontend_content')
    <!--Breadcrumb Area start-->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <ul>
                        <li><a href="{{route('cartpro.home')}}">@lang('file.Home')</a></li>
                        <li class="active">@lang('file.Daily Deals')</li>
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
                    <div class="col-lg-3">
                        <div class="sidebar_filters">
                            <div class="sidebar-widget sidebar-category-list">
                                <div class="sidebar-title">
                                    <h2 data-bs-toggle="collapse" href="#collapseCategory" aria-expanded="true">@lang('file.Browse Categories')</h2>
                                </div>
                                <div class="category-sub-menu style1 mar-top-15 collapse show" id="collapseCategory">
                                    <ul>
                                        @forelse ($categories->where('parent_id',NULL) as $category)
                                            <li class="">
                                                <a href="{{route('cartpro.category_wise_products',$category->slug)}}">
                                                    {{$category->catTranslation->category_name ?? $category->categoryTranslationDefaultEnglish->category_name ?? null}}
                                                </a>
                                            </li>
                                        @empty
                                            <p>@lang('file.No Products Found')</p>
                                        @endforelse

                                    </ul>
                                </div>
                            </div>

                            <!-- Filter By Attribute Value-->
                            {{-- @if ($attribute_with_values)
                                <form id="filterByAttributeValue">
                                    @csrf
                                    @foreach ($attribute_with_values as $key => $item)
                                        <div class="sidebar-widget filters">
                                            <div class="sidebar-title">
                                                <h2 data-bs-toggle="collapse" href="#collapseSize" aria-expanded="true">@lang('file.Filter By') {{$item->attributeTranslation->attribute_name ?? null}}</h2>
                                            </div>
                                            <div class="filter-area collapse show" id="collapseSize">
                                                <div class="size-checkbox">
                                                    <ul class="filter-opt size pt-2">
                                                        @if ($item->attributeValueTranslations->isNotEmpty())
                                                            @foreach ($item->attributeValueTranslations as $value)
                                                                <li>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <label class="custom-control-label attribute_value" data-attribute_value_id="" data-attribute_value_name="{{$value->attribute_value_id}}" data-attribute_value_name="{{$item->attributeTranslation->attribute_name}}" for="size-s" ><span class="size-block">{{$value->attribute_name}}</span></label>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div><button type="submit" class="mt-2 btn btn-success">{{__('file.Filter')}}</button></div>
                                </form>
                            @endif --}}
                        </div>
                    </div>

                    <div class="col-lg-9">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="page-title h5 uppercase mb-0"></h1>
                            <span class="d-none d-md-block"><strong class="theme-color">{{count($products)}}</strong> @lang('file.Products Found')</span>
                        </div>

                        <div class="products-header">
                            <ul class="nav shop-item-filter-list">
                                <li class="d-none d-md-block"><a class="view-grid active"><i class="ti-view-grid"></i></a></li>
                                <li class="d-none d-md-block"><a class="view-list"><i class="ti-layout-list-thumb"></i></a></li>
                                <li class="d-md-block d-sm-block d-lg-none"><a class="filter-icon"><i class="las la-sliders-h"></i> @lang('file.Filters')</a></li>
                            </ul>
                            {{-- <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                @lang('file.Show')
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item active limitShopProductShow" data-id="2" href="#" >2</a></li>
                                    <li><a class="dropdown-item limitShopProductShow" data-id="3" href="#">3</a></li>
                                    <li><a class="dropdown-item limitShopProductShow" data-id="4" href="#">4</a></li>
                                    <li><a class="dropdown-item limitShopProductShow" data-id="5" href="#">5</a></li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                @lang('file.Sort by')
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item sortBy" data-condition="latest">{{__('file.Latest')}}</a></li>
                                    <li><a class="dropdown-item sortBy" data-condition="low_to_high">@lang('file.Price: Low to High')</a></li>
                                    <li><a class="dropdown-item sortBy" data-condition="high_to_low">@lang('file.Price: High to Low')</a></li>
                                </ul>
                            </div> --}}
                        </div>


                        <!--Shop product wrapper starts-->
                        <div class="shop-products-wrapper">
                            <div class="product-grid shopProductsField">
                                @forelse ($products as $item)
                                        <form class="addToCart">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{$item->id}}">
                                            <input type="hidden" name="product_slug" value="{{$item->slug}}">
                                            <input type="hidden" name="category_id" value="{{$category_ids[$item->id]->category_id}}">
                                            <input type="hidden" name="qty" value="1">

                                            <div class="product-grid-item">
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
                                                        <div class="product-short-description">
                                                            {{$item->short_description ?? $item->short_description ?? null}}
                                                        </div>
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
                                                                    @if ($item->special_price>0 && $item->special_price>0 && $item->special_price < $item->price)
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
                                                    <div class="product-options">
                                                        <div class="product-price mt-2">
                                                            @if ($item->special_price>0 && $item->special_price>0 && $item->special_price < $item->price)
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
                                                        @if (($item->manage_stock==1 && $item->qty==0) || ($item->in_stock==0))
                                                            <button class="button style1 sm d-block w-100 mt-3 mb-3" disabled title="{{__('file.Out of Stock')}}" data-bs-toggle="tooltip" data-bs-placement="top"><i class="las la-cart-plus"></i>{{__('file.Add to cart')}}</button>
                                                        @else
                                                            <button class="button style1 sm d-block w-100 mt-3 mb-3" type="submit" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('file.Add to cart')}}"><i class="las la-cart-plus"></i>{{__('file.Add to cart')}}</button>
                                                        @endif
                                                        <a class="button style1 sm d-block align-items-center @auth add_to_wishlist @else forbidden_wishlist @endauth" data-product_id="{{$item->id}}" data-product_slug="{{$item->slug}}" data-category_id="{{$category->id  ?? null}}" data-qty="1" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('file.Add to wishlist')}}"><span class="ti-heart @auth add_to_wishlist @else forbidden_wishlist @endauth"></span>{{__('file.Add to wishlist')}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Shop Page Ends-->

        @forelse ($products as $item)
            @include('frontend.includes.quickshop_shop')
        @empty
        @endforelse

@endsection

@push('scripts')
    <script type="text/javascript">

        //Limit Product Show
        $(document).on('click','.limitShopProductShow',function(event) {
            event.preventDefault();
            var limit_data = $(this).data('id');
            $.ajax({
                url: "{{ route('cartpro.limit_shop_product_show') }}",
                type: "GET",
                data: {limit_data:limit_data},
                success: function (data) {
                    console.log(data);
                    $('.shopProductsField').empty().html(data);
                }
            })
        });

        $('.sortBy').on('click',function(e){
            e.preventDefault();
            var condition = $(this).data('condition');
            $.ajax({
                url: "{{route('cartpro.shop_products_show_sortby')}}",
                type: "GET",
                data: {condition:condition},
                success: function (data) {
                    console.log(data);
                    $('.shopProductsField').empty();
                    $('.shopProductsField').html(data);
                }
            })
        });

        $(document).on('click','.forbidden_wishlist',function(event) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please Login First',
            });
        });

        $('.attribute_value_productTab1').on("click",function(e){
            e.preventDefault();
            $(this).addClass('selected');

            var selectedVal = $(this).data('value_id');
            values.push(selectedVal);
            $('.value_ids_shop').val(values);
        });
    </script>
@endpush

