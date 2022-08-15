    <!--Header Area starts-->
    <header>
        @if (!Cookie::has('top_banner') && env('TOPBAR_BANNER_ENABLED'))
            <div id="top_banner" class="text-center" style="background-color:#e5e8ec">
                <img src="{{asset($topbar_logo_path)}}" alt="">
                <a class="button sm" id="bannerSlideUp"><i class="las la-times"></i></a>
            </div>
        @endif

        <div id="header-top" class="header-top">
            <div class="container">
                <div class="d-lg-flex d-xl-flex justify-content-between">
                    <div class="header-top-left d-none d-lg-flex d-xl-flex">
                        <ul class="header-top-social menu">
                            @if(isset($storefront_facebook_link))
                            <li><a href="{{$storefront_facebook_link}}"><i class="ti-facebook"></i></a></li>
                            @endif
                            @if(isset($storefront_twitter_link))
                            <li><a href="{{$storefront_twitter_link}}"><i class="ti-instagram"></i></a></li>
                            @endif
                            @if(isset($storefront_instagram_link))
                            <li><a href="{{$storefront_instagram_link}}"><i class="ti-twitter"></i></a></li>
                            @endif
                            @if(isset($storefront_youtube_link))
                            <li><a href="{{$storefront_youtube_link}}"><i class="ti-youtube"></i></a></li>
                            @endif
                        </ul>
                    </div>
                    <div class="header-top-middle d-none d-lg-flex d-xl-flex">
                        <span class="announcement">
                            <!--Welcome-->
                            @if ($settings[0]->settingTranslation || $settings[0]->settingTranslationDefaultEnglish)
                                {{$settings[0]->settingTranslation->value ?? $settings[0]->settingTranslationDefaultEnglish->value ?? NULL}}
                            @endif
                        </span>
                    </div>
                    <div class="header-top-right">
                        <ul>
                            <li class="has-dropdown"><a href="#"><i class="las la-language"></i>&nbsp; {{$languages[$locale]->language_name}}</a>
                                <ul class="dropdown p-0">
                                    @foreach ($languages as $item)
                                        <li><a href="{{route('cartpro.default_language_change',$item->id)}}" {{$item->local==Session::get('currentLocal') ? 'selected': ''}}>{{$item->language_name}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="has-dropdown"><a href="#"><i class="las la-money-bill"></i>&nbsp; @if(Session::has('currency_code')) {{Session::get('currency_code')}} @else {{env('DEFAULT_CURRENCY_CODE')}} @endif</a>
                                <ul class="dropdown p-0">
                                    @foreach ($currency_codes as $item)
                                        <li><a href="{{route('cartpro.currency_change',$item->currency_code)}}" {{$item->currency_code==Session::get('currency_code') ? 'selected': ''}}>{{$item->currency_code}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="header-middle" class="header-middle">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-7">
                        <div class="mobile-menu-icon d-lg-none"><i class="ti-menu"></i></div>
                        <div class="logo">
                            <a href="{{route('cartpro.home')}}">
                                <img src="{{$header_logo_path}}" alt="Brand logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-flex d-xl-flex middle-column justify-content-center">
                        <form id="KeyWordHit" class="header-search" action="{{route('cartpro.search_product')}}" method="POST">
                            @csrf

                            <input type="text" list="browsers" id="searchText" placeholder="Search Products" name="search">
                            <button type="submit" class="btn btn-search"><i class="ti-search"></i></button>
                            {{-- <span class="btn btn-search"><i class="ti-search"></i></span> --}}
                            <!-- Search Field-->
                            <div class="row" id="search_field">
                                <ul id="result">
                                </ul>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-3 col-5">
                        <ul class="offset-menu-wrapper p-0">
                            <li class="d-lg-none">
                                <a><i class="las la-search" data-bs-toggle="collapse" href="#mobile-search" role="button" aria-expanded="false" aria-controls="mobile-search"></i></a>
                            </li>
                            @auth
                                <li>
                                    <a href="{{route('user_account')}}"><i class="las la-user" data-bs-toggle="tooltip" data-bs-placement="bottom" title="My Account"></i></a>
                                </li>
                            @else
                                <li>
                                    <a href="{{route('customer_login_form')}}"><i class="las la-user-lock" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Login"></i></a>
                                </li>
                            @endauth


                            @auth
                                <li class="wishlist__menu d-none d-lg-inline-block d-xl-inline-block">
                                    <a href="{{route('wishlist.index')}}">
                                        <i class="lar la-heart" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Wishlist"></i>
                                    </a>
                                    <span class="badge badge-light wishlist_count">{{$total_wishlist }}</span>
                                </li>
                            @else
                                <li class="cart__menu d-none d-lg-inline-block d-xl-inline-block">
                                    <a href="#">
                                        <i class="lar la-heart" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Wishlist"></i>
                                    </a>
                                    <span class="badge badge-light">0</span>
                                </li>
                            @endauth


                            <li class="cart__menu">
                                <i class="las la-shopping-cart" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Cart"></i>
                                <span class="badge badge-light cart_count">{{$cart_count}}</span>
                                <span class="total">
                                    @if(env('CURRENCY_FORMAT')=='suffix')
                                        <span class="cart_total">{{$cart_total}}</span> @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                    @else
                                        @include('frontend.includes.SHOW_CURRENCY_SYMBOL') <span class="cart_total">{{$cart_total}}</span>
                                    @endif
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @php
            $categories = \App\Models\Category::with(['catTranslation','parentCategory.catTranslation','categoryTranslationDefaultEnglish','child.catTranslation'])
                        ->where('is_active',1)
                        ->orderBy('is_active','DESC')
                        ->orderBy('id','ASC')
                        ->get();
        @endphp

        <div class="header-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-md-4 d-none d-lg-flex d-xl-flex">
                        <div class="category-list">
                            <ul class="pl-0">
                                <li class="has-dropdown"><a class="category-button" href="#"><i class="ti-menu"></i>{{__('file.Shop By Category')}}</a>
                                    <ul id="cat_menu" class="dropdown p-0">
                                        @forelse ($categories->where('parent_id',NULL) as $category)
                                            @if ($category->child->isNotEmpty())
                                                <li class="has-dropdown"><a href="{{route('cartpro.category_wise_products',$category->slug)}}"><i class="{{$category->icon ?? null}}"></i> {{$category->catTranslation->category_name ?? $category->categoryTranslationDefaultEnglish->category_name ?? null}}</a>
                                                    <ul class="dropdown">
                                                        @foreach ($category->child as $item)
                                                            <li><a href="{{route('cartpro.category_wise_products',$item->slug)}}"><i class="{{$item->icon ?? null}}"></i>{{$item->catTranslation->category_name ?? $item->categoryTranslationDefaultEnglish->category_name ?? null}}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <li><a href="{{route('cartpro.category_wise_products',$category->slug)}}"><i class="{{$category->icon ?? null}}"></i>{{$category->catTranslation->category_name ?? $category->categoryTranslationDefaultEnglish->category_name ?? null}}</a></li>
                                            @endif
                                        @empty
                                        @endforelse
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-9 col-md-8">
                        <div class="main-header-inner">
                            <div id="main-menu" class="main-menu">
                                <nav id="mobile-nav">

                                    <ul class="nav nav-tabs" id="menu_tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" data-toggle="tab" href="#mobile_menu" role="tab" aria-controls="mobile_menu" aria-selected="true">Menu</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-toggle="tab" href="#mobile_cat" role="tab" aria-controls="mobile_cat" aria-selected="false">Categories</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="menu_tab_content">
                                        <div class="tab-pane fade show active" id="mobile_menu" role="tabpanel" aria-labelledby="menu-tab">
                                            <ul class="pl-0">
                                                @php
                                                    $str = url()->current();
                                                    $data = explode("/",$str);
                                                    $last_word = $data[count($data)-1];
                                                @endphp

                                                <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="{{route('cartpro.home')}}">{{__('file.Home')}}</a></li>

                                                @if ($storefront_shop_page_enabled)
                                                    <li class="{{ Request::is('shop') ? 'active' : '' }}"><a href="{{route('cartpro.shop')}}">{{__('file.Shop')}}</a></li>
                                                @endif

                                                @if ($storefront_brand_page_enabled)
                                                    <li class="{{ Request::is('brands') ? 'active' : '' }}"><a href="{{route('cartpro.brands')}}">{{__('file.Brands')}}</a></li>
                                                @endif


                                                @if ($menu!=NULL)
                                                    @forelse ($menu->items as $menu_item)
                                                        @if ($menu_item->child->isNotEmpty())
                                                            <li class="has-dropdown"><a href="{{$menu_item->link}}">{{$menu_item->label}}</a>
                                                                <ul class="dropdown">
                                                                    @foreach($menu_item->child as $child)
                                                                        <!--Extra-->
                                                                        @if ($child->child->isNotEmpty())
                                                                            @if ($child->locale==$locale)
                                                                                @if(strpos($menu_item->link, 'https://') !== false)
                                                                                    <li class="has-dropdown"><a href="{{$child->link}}">{{$child->label}}</a>
                                                                                @else
                                                                                    <li class="has-dropdown"><a href="{{route('page.Show',$child->link)}}">{{$child->label}}</a></li>
                                                                                @endif
                                                                            @endif
                                                                                    <ul class="dropdown">
                                                                                        @foreach($child->child as $sub_child)
                                                                                            @if ($sub_child->locale==$locale)
                                                                                                @if(strpos($sub_child->link, 'https://') !== false)
                                                                                                    <li><a href="{{$sub_child->link}}">{{$sub_child->label}}</a></li>
                                                                                                @else
                                                                                                    <li><a href="{{route('page.Show',$sub_child->link)}}">{{$sub_child->label}}</a></li>
                                                                                                @endif
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </li>
                                                                        @else
                                                                            <li><a href="{{$child->link}}">{{$child->label}}</a></li>
                                                                        @endif
                                                                        <!--Extra End-->
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @else
                                                            @if ($menu_item->locale==$locale)
                                                                @if(strpos($menu_item->link, 'https://') !== false)
                                                                    <li><a href="{{$menu_item->link}}">{{$menu_item->label}}</a></li>
                                                                @else
                                                                    <li class="{{$last_word==$menu_item->link ? 'active' : ''}}"><a href="{{route('page.Show',$menu_item->link)}}">{{$menu_item->label}}</a></li>
                                                                @endif
                                                                    <!-- <li><a href="{{$menu_item->link}}">{{$menu_item->label}}</a></li> -->
                                                            @endif
                                                            <!-- <li><a href="{{$menu_item->link}}">{{$menu_item->label}}</a></li> -->
                                                        @endif
                                                    @empty
                                                    @endforelse
                                                @endif
                                                <li class="deal-menu-item"><a href="{{route('cartpro.daily_deals')}}"><i class="las la-tag d-none d-md-inline-block"></i> @lang('file.Daily Deals')</a></li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane fade" id="mobile_cat" role="tabpanel" aria-labelledby="category-tab">

                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-mobile collapse" id="mobile-search">
            <div class="container">
                <div id="header-search" class="d-lg-none">

                </div>
            </div>
        </div>
    </header>

    <div class="body__overlay"></div>

    <!-- Offset Wrapper starts-->
    <div class="offset__wrapper">
        <div class="shopping__cart">
            <div class="shopping__cart__header">
                <span class="h6">My Cart</span>
                <div class="offsetmenu__close__btn">
                    <i class="las la-times"></i>
                </div>
            </div>
            <div class="shopping__cart__inner">
                <div class="shp__cart__wrap">

                        <div class="cart_list">
                            @forelse ($cart_contents as $item)
                                <div id="{{$item->rowId}}" class="shp__single__product">
                                    <div class="shp__pro__thumb">
                                        <a href="#">
                                            <img src="{{asset('public/'.$item->options->image ?? null)}}">
                                        </a>
                                    </div>
                                    <div class="shp__pro__details">
                                        <h2><a href="{{url('product/'.$item->options->product_slug.'/'. $item->options->category_id)}}">{{$item->name}}</a></h2>
                                        <span class="my_cart_specific_qty_{{$item->rowId}}">{{$item->qty}}</span> x <span class="shp__price">
                                            @if(env('CURRENCY_FORMAT')=='suffix')
                                                {{$item->price * $CHANGE_CURRENCY_RATE}} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                            @else
                                                @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{$item->price * $CHANGE_CURRENCY_RATE}}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="remove__btn">
                                        <a href="#" class="remove_cart" data-id="{{$item->rowId}}" title="Remove this item"><i class="las la-times"></i></a>
                                    </div>
                                </div>
                            @empty
                            <div class="empty-cart">
                                <img src="{{asset('public/frontend/images/empty-cart.png')}}">
                                <h5>@lang('file.Your cart is empty')</h5>
                            </div>
                            @endforelse
                        </div>

                </div>
            </div>
            <div class="shopping__cart__footer">
                <div class="shoping__total">
                    <span class="subtotal">@lang('file.Subtotal')</span>
                    <span class="total__price">
                        @if(env('CURRENCY_FORMAT')=='suffix')
                            <span class="total_price">{{$cart_total * $CHANGE_CURRENCY_RATE}}</span> @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                        @else
                            @include('frontend.includes.SHOW_CURRENCY_SYMBOL') <span class="total_price">{{$cart_total * $CHANGE_CURRENCY_RATE}}</span>
                        @endif
                    </span>
                </div>
                <div class="shopping__btn">
                    <a class="button style3" href="{{route('cart.view_details')}}">{{__('file.View Cart')}}</a>
                    <a class="button style1" href="{{route('cart.checkout')}}">@lang('file.Checkout')</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Offset Wrapper ends -->
    <!-- Header Area  ends -->

@push('scripts')
    <script>
        $('#top_banner').on("click",function(e){
            console.log(1);
            $.get({
                url: "{{route('cartpro.set_cookie')}}",
                type: "GET",
                data: {cookie_type:'top_banner'},
                success: function (data) {
                    console.log(data);
                    if (data=='disable') {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1500,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                        Toast.fire({
                            icon: 'success',
                            title: 'Banner disabled successfully'
                        })
                    }
                }
            })
        });
    </script>
@endpush
