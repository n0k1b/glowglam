@extends('frontend.layouts.master')
@section('title','Category Wise Products')

@section('extra_css')
<link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{asset('public/frontend/css/jquery-ui-min.css')}}">
<noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{asset('public/frontend/css/jquery-ui-min.css')}}"></noscript>
@endsection
@section('frontend_content')
    <!--Breadcrumb Area start-->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <ul>
                        <li><a href="{{route('cartpro.home')}}">@lang('file.Home')</a></li>
                        <li class="active">@lang('file.Category')</li>
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
                    <div class="sidebar_filters mb-5">

                        <form id="sidebarFilter">

                            <!--sidebar-categories-box start-->
                            <div class="sidebar-widget sidebar-category-list">
                                @if ($category->child->count()!=0)
                                <div class="sidebar-title">
                                    <h2 data-bs-toggle="collapse" href="#collapseCategory" aria-expanded="true">@lang('file.Categories')</h2>
                                </div>
                                @endif

                                @if($category->child)
                                <!-- category-sub-menu start -->
                                <div class="category-sub-menu style1 mar-top-15 collapse show" id="collapseCategory">
                                    <ul>
                                        @forelse ($category->child as $item)
                                            <li><a href="{{route('cartpro.category_wise_products',$item->slug)}}">{{$item->catTranslation->category_name ?? $item->categoryTranslationDefaultEnglish->category_name ?? null }}</a> <span class="count">

                                                @php $count =0; @endphp
                                                @forelse ($item->categoryProduct as $childCategoryProduct)
                                                    @if ($childCategoryProduct->product)
                                                        @php $count++; @endphp
                                                    @endif
                                                @empty
                                                @endforelse
                                                ({{$count}})

                                            </span>
                                                @if ($item->child)
                                                    @forelse ($item->child as $value)
                                                        <ul>
                                                            <li><a href="{{route('cartpro.category_wise_products',$value->slug)}}">{{$value->catTranslation->category_name ?? $value->categoryTranslationDefaultEnglish->category_name ?? null }}<span class="count">
                                                                @php $count =0; @endphp
                                                                @forelse ($value->categoryProduct as $childCategoryProduct)
                                                                    @if ($childCategoryProduct->product)
                                                                        @php $count++; @endphp
                                                                    @endif
                                                                @empty
                                                                @endforelse
                                                                ({{$count}})
                                                            </span></a></li>
                                                        </ul>
                                                    @empty
                                                    @endforelse
                                                @endif
                                            </li>
                                        @empty
                                        @endforelse
                                    </ul>
                                </div>
                                <!-- category-sub-menu end -->
                                @endif
                            </div>
                            <!--sidebar-categores-box end  -->


                            <!--sidebar-categores-box start  -->
                            <!-- Filter By Price -->
                            <div class="sidebar-widget filters">
                                <div class="sidebar-title">
                                    <h2 data-bs-toggle="collapse" href="#collapsePrice" aria-expanded="true">@lang('file.Filter By Price')</h2>
                                </div>
                                <div class="filter-area collapse show" id="collapsePrice">
                                    {{-- <form id="priceRange" action="{{route('cartpro.category.price_range')}}" method="get"> --}}
                                        <div id="slider-range" class="price-range mar-bot-20"></div>
                                        <div class="d-flex justify-content-center">
                                            <div><input type="text" id="amount" name="amount"></div>
                                            <div><input type="hidden" name="category_slug" value="{{$category->slug ?? null}}"></div>
                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>


                            <!-- Filter By Attribute Value-->
                            @if (count($attribute_values)>0)
                                {{-- <form id="filterByAttributeValue"> --}}
                                    {{-- @csrf --}}
                                    <input type="hidden" name="attribute_value_ids" class="attribute_value_ids" id="attribute_value_ids">
                                    <div><input type="hidden" name="category_slug" value="{{$category->slug}}"></div>

                                    @foreach ($attribute_values->keyBy('attribute_name') as $key => $item)
                                        <div class="sidebar-widget filters">
                                            <div class="sidebar-title">
                                                <h2 data-bs-toggle="collapse" href="#collapseSize" aria-expanded="true">@lang('file.Filter By') {{$key}}</h2>
                                            </div>
                                            <div class="filter-area collapse show" id="collapseSize">
                                                <div class="size-checkbox">
                                                    <ul class="filter-opt size pt-2">
                                                        @foreach ($attribute_values->where('attribute_name',$key) as $value)
                                                            <li>
                                                                <div class="custom-control custom-checkbox">
                                                                    <label class="custom-control-label attribute_value" data-attribute_value_id="{{$value->attribute_value_id}}" data-attribute_value_name="{{$value->attribute_value_name}}" for="size-s"><span class="size-block">{{$value->attribute_value_name}}</span></label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                {{-- </form> --}}
                            @endif

                            <!--sidebar-categories-box end-->
                            <div><button type="submit" class="mt-2 btn btn-success">{{__('Filter')}}</button></div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1 class="page-title h5 uppercase mb-0">{{$category->catTranslation->category_name ?? $category->categoryTranslationDefaultEnglish->category_name ?? null}}</h1>
                        @if ($category)
                            <span class="d-none d-md-block"><strong class="theme-color">{{$product_count}}</strong> @lang('file.Products Found')</span>
                        @endif
                    </div>

                    <div class="products-header">
                        <ul class="nav shop-item-filter-list">
                            <li class="d-none d-md-block d-lg-block"><a class="view-grid active"><i class="ti-view-grid"></i></a></li>
                            <li class="d-none d-md-block d-lg-block"><a class="view-list"><i class="ti-layout-list-thumb"></i></a></li>
                            <li class="d-md-block d-sm-block d-lg-none"><a class="filter-icon"><i class="las la-sliders-h"></i> @lang('file.Filters')</a></li>
                        </ul>
                        <!-- shop-item-filter-list start -->
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            @lang('file.Show')
                            </button>
                            <input type="hidden" id="categorySlug" value="{{$category->slug}}">
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item active limitCategoryProductShow" data-id="2" href="#" >2</a></li>
                                <li><a class="dropdown-item limitCategoryProductShow" data-id="3" href="#">3</a></li>
                                <li><a class="dropdown-item limitCategoryProductShow" data-id="4" href="#">4</a></li>
                                <li><a class="dropdown-item limitCategoryProductShow" data-id="5" href="#">5</a></li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            @lang('file.Sort by')
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item sortBy" data-condition="latest" data-category_slug="{{$category->slug}}">Latest</a></li>
                                <li><a class="dropdown-item sortBy" data-condition="low_to_high" data-category_slug="{{$category->slug}}">Price: Low to High</a></li>
                                <li><a class="dropdown-item sortBy" data-condition="high_to_low" data-category_slug="{{$category->slug}}">Price: High to Low</a></li>
                            </ul>
                        </div>
                        <!-- shop-item-filter-list end -->
                    </div>


                    <!--Shop product wrapper starts-->
                    <div class="shop-products-wrapper">
                        <div class="product-grid categoryWiseProductField">
                            @if ($category->categoryProduct)
                                @forelse ($category->categoryProduct as $item)
                                    @if (isset($item->product) && $item->product->is_active==1) <!--Change in query later-->
                                        <form class="addToCart">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{$item->product_id}}">
                                            <input type="hidden" name="product_slug" value="{{$item->product->slug}}">
                                            <input type="hidden" name="category_id" value="{{$category->id ?? null}}">
                                            <input type="hidden" name="qty" value="1">

                                            <div class="product-grid-item">
                                                <div class="single-product-wrapper">
                                                    <div class="single-product-item">
                                                        @if ($item->productBaseImage!=NULL && Illuminate\Support\Facades\File::exists(public_path($item->product->baseImage->image)))
                                                            <a href="{{url('product/'.$item->product->slug.'/'. $category->id)}}"><img class="lazy" data-src="{{asset('public/'.$item->product->baseImage->image)}}"></a>
                                                        @else
                                                            <a href="{{url('product/'.$item->product->slug.'/'. $category->id)}}"><img src="https://dummyimage.com/221x221/e5e8ec/e5e8ec&text=CartPro"></a>
                                                        @endif

                                                        <!-- product-promo-text -->
                                                        @include('frontend.includes.product-promo-text',['manage_stock'=>$item->product->manage_stock, 'qty'=>$item->product->qty, 'in_stock'=>$item->product->in_stock, 'in_stock'=>$item->product->in_stock, 'current_date'=>date('Y-m-d') ,'new_to'=>$item->product->new_to])
                                                        <!--/ product-promo-text -->

                                                        <div class="product-overlay">
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#id_{{$item->product->id}}"> <span class="ti-zoom-in" data-bs-toggle="tooltip" data-bs-placement="top" title="quick view"></span></a>
                                                            <a><span class="ti-heart @auth add_to_wishlist @else forbidden_wishlist @endauth" data-product_id="{{$item->product_id}}" data-product_slug="{{$item->product->slug}}" data-category_id="{{$category->id  ?? null}}" data-qty="1" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('file.Add to wishlist')"></span></a>
                                                        </div>
                                                    </div>
                                                    <div class="product-details">
                                                        <a class="product-name" href="{{url('product/'.$item->product->slug.'/'. $category->id)}}">
                                                            {{$item->product->productTranslation->product_name ?? $item->product->productTranslationEnglish->product_name ?? null}}
                                                        </a>
                                                        <div class="product-short-description">
                                                            {{$item->product->productTranslation->short_description ?? $item->product->productTranslationEnglish->short_description ?? null}}
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <div class="rating-summary">
                                                                    <div class="rating-result" title="60%">
                                                                        <ul class="product-rating">
                                                                            @php
                                                                                for ($i=1; $i <=5 ; $i++){
                                                                                    if ($i<= round($item->product->avg_rating)){  @endphp
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
                                                                    @if ($item->product->special_price!=NULL && $item->product->special_price>0 && $item->product->special_price < $item->product->price)
                                                                        @if(env('CURRENCY_FORMAT')=='suffix')
                                                                            <span class="promo-price">{{ number_format((float)$item->product->special_price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '')}} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')</span>
                                                                            <span class="old-price">{{ number_format((float)$item->product->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')</span>
                                                                        @else
                                                                            <span class="promo-price">@include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->special_price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '')}} </span>
                                                                            <span class="old-price"> @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}</span>
                                                                        @endif
                                                                    @else
                                                                        @if(env('CURRENCY_FORMAT')=='suffix')
                                                                            <span class="price">{{ number_format((float)$item->product->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')</span>
                                                                        @else
                                                                            <span class="price">@include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}</span>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div>
                                                                @if (($item->product->manage_stock==1 && $item->product->qty==0) || ($item->product->in_stock==0))
                                                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="Disabled"><button class="btn button style2 sm" disabled><i class="las la-cart-plus"></i></button></span>
                                                                @else
                                                                    <button class="button style2 sm" type="submit" title="Add To Cart" data-bs-toggle="tooltip" data-bs-placement="top"><i class="las la-cart-plus"></i></button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="product-options">
                                                        <div class="product-price mt-2">
                                                            @if ($item->product->special_price!=NULL && $item->product->special_price>0 && $item->product->special_price<$item->product->price)
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

                                                        @if (($item->product->manage_stock==1 && $item->product->qty==0) || ($item->product->in_stock==0))
                                                            <button disabled class="button style1 sm d-block w-100 mt-3 mb-3" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('file.Out of Stock')}}"><i class="las la-cart-plus"></i>{{__('file.Add to Cart')}}</button>
                                                        @else
                                                            <button class="button style1 sm d-block w-100 mt-3 mb-3" type="submit" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('file.Add to Cart')}}"><i class="las la-cart-plus"></i>{{__('file.Add to Cart')}}</button>
                                                        @endif
                                                        <a class="button style1 sm d-block align-items-center @auth add_to_wishlist @else forbidden_wishlist @endauth" data-product_id="{{$item->product_id}}" data-product_slug="{{$item->product->slug}}" data-category_id="{{$category->id  ?? null}}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('file.Add to wishlist')}}"><span class="ti-heart"></span> {{__('file.Add to wishlist')}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                @empty
                                    <h2 class="h4">@lang('file.No items found')</h2>
                                @endforelse
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Page Ends-->

    <!-- Quick Shop Modal starts -->
    @forelse ($category->categoryProduct as $item)
        @if ($item->product!==NULL && $item->product->is_active==1)
            @include('frontend.includes.quickshop')
        @endif
    @empty
    @endforelse
@endsection

@push('scripts')
    <script src="{{asset('public/frontend/js/jquery-ui.min.js')}}"></script>
    <script type="text/javascript">

        $('.attribute_value_productTab1').on("click",function(e){
            e.preventDefault();
            $(this).addClass('selected');

            var selectedVal = $(this).data('value_id');
            values.push(selectedVal);
            $('.value_ids_productTab1').val(values);
        });

        //Limit Category Product Show
        $(document).on('click','.limitCategoryProductShow',function(event) {
            event.preventDefault();
            var limit_data = $(this).data('id');
            var category_slug = $('#categorySlug').val();
            $.ajax({
                url: "{{ route('cartpro.limit_category_product_show') }}",
                type: "GET",
                data: {limit_data:limit_data, category_slug:category_slug},
                success: function (data) {
                    console.log(data);
                    $('.categoryWiseProductField').html(data);
                }
            })
        });

        $('.sortBy').on('click',function(e){
            e.preventDefault();
            var condition = $(this).data('condition');
            var category_slug = $(this).data('category_slug');
            $.ajax({
                url: "{{route('cartpro.category_wise_products_condition')}}",
                type: "GET",
                data: {condition:condition, category_slug:category_slug},
                success: function (data) {
                    console.log(data);
                    $('.categoryWiseProductField').empty();
                    $('.categoryWiseProductField').html(data);
                }
            })
        });

        $("#priceRange" ).on('click',function(e){
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: "GET",
                url: "{{route('cartpro.category.price_range')}}",
                data: form.serialize(),
                success: function(data){
                    console.log(data);
                    $('.categoryWiseProductField').empty().html(data);
                }
            });
        });

        let attribute_values = [];
        $('.attribute_value').on('click',function(e){
            $(this).addClass('text-primary');

            var selectedVal = $(this).data('attribute_value_id');

            attribute_values.push(selectedVal);
            $('#attribute_value_ids').val(attribute_values);
        });

        $('#filterByAttributeValue').on('submit',function(e) {
            e.preventDefault();
            var form = $(this);

            var attribute_value_ids = $('.attribute_value_ids').val();
            attribute_values.splice(0, attribute_values.length)

            $.ajax({
                url: "{{route('cartpro.category.filter_by_attribute_value')}}",
                type: "GET",
                data: form.serialize(),
                success: function(data){
                    console.log(data);
                    if(data.type=='error'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Please select at least one',
                        });
                    }else{
                        $('.categoryWiseProductField').empty();
                        $('.categoryWiseProductField').html(data);
                        $('.attribute_value').removeClass('text-primary');
                    }
                }
            });
        });

        //New
        $('#sidebarFilter').on('submit',function (e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: "GET",
                url: "{{route('cartpro.category.sidebar_filter')}}",
                data: form.serialize(),
                success: function(data){
                    console.log(data);
                    $('.categoryWiseProductField').empty().html(data);
                }
            });
            console.log(form);
        });
    </script>

    <script>
        /*------------------------
             price range slider
        --------------------------*/
        let moneySymbol = "<?php echo ($CHANGE_CURRENCY_SYMBOL!=NULL ? $CHANGE_CURRENCY_SYMBOL : env('DEFAULT_CURRENCY_SYMBOL')) ?>";

        if ($('#slider-range').length) {
            $("#slider-range").slider({
                range: true,
                min: 0 * {{$CHANGE_CURRENCY_RATE}},
                max: 10000 * {{$CHANGE_CURRENCY_RATE}},
                values: [0 * {{$CHANGE_CURRENCY_RATE}}, 5000 * {{$CHANGE_CURRENCY_RATE}}],
                slide: function(event, ui) {
                    $("#amount").val(moneySymbol+' '+ + ui.values[0] + " - "+moneySymbol+' ' + ui.values[1]);
                }
            });
            $("#amount").val(moneySymbol+' '+ $("#slider-range").slider("values", 0) +
                " - "+moneySymbol+' '+ $("#slider-range").slider("values", 1));
        }
    </script>
@endpush
