@extends('frontend.layouts.master')
@section('frontend_content')


<!--Home Banner starts -->
<div class="banner-area v3">
    <div class="container">
        <div class="single-banner-item style2">
            <div class="row">
                @if ($store_front_slider_format == 'full_width')
                    <div class="col-md-12">
                        <div class="banner-slider">
                            @foreach ($sliders as $item)
                                @if ($item->sliderTranslation->isNotEmpty())
                                    <div class="item">
                                        @if($item->slider_image!==null && Illuminate\Support\Facades\File::exists(public_path($item->slider_image)))
                                            <div class="img-fill" style="background-image: url({{url('public/'.$item->slider_image_full_width)}}); background-size: cover; background-position: center;">
                                        @else
                                            <div class="img-fill" style="background-image: url('https://dummyimage.com/1269x300/e5e8ec/e5e8ec&text=Slider'); background-size: cover; background-position: center;">
                                        @endif
                                            <div class="@if($item->text_alignment=='right') info right @else info @endif" >
                                                <div>
                                                    <h3 style="color: {{$item->text_color ?? '#ffffff'}} ">{{$item->sliderTranslation[0]->slider_title}}</h3>
                                                    <h5 style="color: {{$item->text_color ?? '#ffffff'}} ">{{$item->sliderTranslation[0]->slider_subtitle}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            @foreach ($slider_banners as $key => $item)
                                <div class="col-sm-4">
                                        <a href="{{$slider_banners[$key]['action_url']}}" target="{{$slider_banners[$key]['new_window']==1 ? '__blank' : '' }}">
                                        @if($slider_banners[$key]['image']!==null && Illuminate\Support\Facades\File::exists(public_path($slider_banners[$key]['image'])))
                                            <div class="slider-banner" style="background-image:url({{asset('public/'.$slider_banners[$key]['image'])}});background-size:cover;background-position: center;">
                                        @else
                                            <div class="slider-banner" style="background-image:url('https://dummyimage.com/75.1526x75.1526/e5e8ec/e5e8ec&text=Slider-Banner');background-size:cover;background-position: center;">
                                        @endif
                                        <h4 class="text-dark">{{$slider_banners[$key]['title']}}</h4>
                                    </div></a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    {{-- Half Width --}}
                    <div class="col-md-8">
                        <div class="banner-slider">
                            @foreach ($sliders as $item)
                                @if ($item->sliderTranslation->isNotEmpty())
                                    <div class="item">
                                        @if($item->slider_image!==null && Illuminate\Support\Facades\File::exists(public_path($item->slider_image)))
                                            <div class="img-fill" style="background-image: url({{url('public/'.$item->slider_image)}}); background-size: cover; background-position: center;">
                                        @else
                                            <div class="img-fill" style="background-image: url('https://dummyimage.com/1269x300/e5e8ec/e5e8ec&text=Slider'); background-size: cover; background-position: center;">
                                        @endif
                                            <div class="@if($item->text_alignment=='right') info right @else info @endif" >
                                                <div>
                                                    <h3 style="color: {{$item->text_color ?? '#ffffff'}} ">{{$item->sliderTranslation[0]->slider_title}}</h3>
                                                    <h5 style="color: {{$item->text_color ?? '#ffffff'}} ">{{$item->sliderTranslation[0]->slider_subtitle}}</h5>

                                                    @if ($item->type=='category')
                                                        <a class="button style1 md" href="{{route('cartpro.category_wise_products',$item->category->slug)}}">Read More</a>
                                                    @elseif ($item->type=='url')
                                                        <a class="button style1 md" href="{{$item->url}}">Read More</a>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-4">
                        @empty(!$slider_banners)
                            @foreach ($slider_banners as $key => $item)
                                <a href="{{$slider_banners[$key]['action_url']}}" target="{{$slider_banners[$key]['new_window']==1 ? '__blank' : '' }}">
                                @if($slider_banners[$key]['image']!==null && Illuminate\Support\Facades\File::exists(public_path($slider_banners[$key]['image'])))
                                    <div class="slider-banner" style="background-image:url({{asset('public/'.$slider_banners[$key]['image'])}});background-size:cover;background-position: center;">
                                @else
                                    <div class="slider-banner" style="background-image:url('https://dummyimage.com/75.1526x75.1526/e5e8ec/e5e8ec&text=Slider-Banner');background-size:cover;background-position: center;">
                                @endif
                                    <h4 class="text-dark">{{$slider_banners[$key]['title']}}</h4>
                                </div></a>
                            @endforeach
                        @endempty
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if ($top_categories_section_enabled==1)
    <section class="category-tab-section pt-0">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title mb-3">
                        <div class="d-flex align-items-center">
                            <h3>{{__('file.Top Categories')}}</h3>
                        </div>
                        <!-- Add Pagination -->
                        <div class="category-navigation">
                            <div class="category-button-prev"><i class="ti-angle-left"></i></div>
                            <div class="category-button-next"><i class="ti-angle-right"></i></div>
                        </div>
                    </div>

                    <div class="category-slider-wrapper swiper-container">
                    <div class="swiper-wrapper">


                        @forelse ($categories->where('top',1) as $item)
                            <div class="swiper-slide">
                                <a href="{{url('category')}}/{{$item->slug}}">
                                    <div class="category-container">
                                        @if($item->image!==null && Illuminate\Support\Facades\File::exists(public_path($item->image)))
                                            <img class="lazy" data-src="{{asset('public/'.$item->image)}}">
                                        @else
                                            <img class="lazy" data-src="https://dummyimage.com/100x100/e5e8ec/e5e8ec&text=Top-Category" alt="...">
                                        @endif

                                        <div class="category-name">
                                            {{$item->catTranslation->category_name ?? $item->categoryTranslationDefaultEnglish->category_name ?? null}}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>
@endif

<!--Three Coloumn Banner Full--->
@if ($three_column_banner_full_enabled==1)
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <a href="{{$settings_new['storefront_slider_banner_1_call_to_action_url']->plain_value}}" target="{{$settings_new['storefront_slider_banner_1_open_in_new_window']->plain_value==1 ? '__blank' : '' }}"><img class="lazy" data-src="{{asset($three_column_full_width_banners_image_1)}}" alt=""></a>
                </div>
                <div class="col-sm-4">
                    <a href="{{$settings_new['storefront_slider_banner_2_call_to_action_url']->plain_value}}" target="{{$settings_new['storefront_slider_banner_2_open_in_new_window']->plain_value==1 ? '__blank' : '' }}"><img class="lazy" data-src="{{asset($three_column_full_width_banners_image_2)}}" alt=""></a>
                </div>
                <div class="col-sm-4">
                    <a href="{{$settings_new['storefront_slider_banner_3_call_to_action_url']->plain_value}}" target="{{$settings_new['storefront_slider_banner_3_open_in_new_window']->plain_value==1 ? '__blank' : '' }}"><img class="lazy" data-src="{{asset($three_column_full_width_banners_image_3)}}" alt=""></a>
                </div>
            </div>
        </div>
    </section>
@endif


<!--Product area starts-->
@if ($settings[81]->plain_value==1)
    <section class="product-tab-section">
        <div class="container">

            <div class="row">
                <div class="col-md-12 text-center">
                    <ul class="nav nav-tabs product-details-tab" id="lionTab" role="tablist">
                        @php $i=0; @endphp
                        @foreach ($settings as $setting)
                            @if ($setting->key =='storefront_product_tabs_1_section_tab_1_title'|| $setting->key =='storefront_product_tabs_1_section_tab_2_title' || $setting->key =='storefront_product_tabs_1_section_tab_3_title' || $setting->key =='storefront_product_tabs_1_section_tab_4_title')
                                <li class="nav-item">
                                    <a @if($i==0) class="nav-link active" @else class="nav-link" @endif data-bs-toggle="tab" href="#{{$setting->key}}" role="tab" aria-selected="true">{{$setting->settingTranslation->value ?? $setting->settingTranslationDefaultEnglish->value ?? null}}</a>
                                </li>
                                @php $i++ ; @endphp
                            @endif
                        @endforeach
                    </ul>
                    <div class="product-navigation">
                        <div class="product-button-next v1"><i class="ti-angle-right"></i></div>
                        <div class="product-button-prev v1"><i class="ti-angle-left"></i></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content mt-3" id="lionTabContent">
                        <!-- Product_Tab_1-Section_1 -->
                        <div class="tab-pane fade show active" id="{{$product_tabs_one_titles[0] ?? null}}" role="tabpanel" aria-labelledby="all-tab">
                            <div class="product-slider-wrapper swiper-container">
                                <div class="swiper-wrapper">
                                    @forelse ($product_tab_one_section_1 as $item)
                                            @if ($item->product!==NULL && $item->product->is_active==1)
                                                <div class="swiper-slide">
                                                    <form action="{{route('product.add_to_cart')}}" class="addToCart" method="post">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{$item->product_id}}">
                                                        <input type="hidden" name="product_slug" value="{{$item->product->slug}}">
                                                        <input type="hidden" name="category_id" value="{{$item->category_id ?? null}}">
                                                        <input type="hidden" name="qty" value="1">

                                                        <div class="single-product-wrapper">
                                                            <div class="single-product-item">
                                                                @if (isset($item->productBaseImage->image) && Illuminate\Support\Facades\File::exists(public_path($item->productBaseImage->image_medium)))
                                                                    <a href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}"><img class="swiper-lazy" data-src="{{asset('public/'.$item->productBaseImage->image_medium)}}"></a>
                                                                @else
                                                                    <a href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}"><img class="swiper-lazy" data-src="https://dummyimage.com/221.6x221.6/e5e8ec/e5e8ec&text=CartPro"></a>
                                                                @endif

                                                                <!-- product-promo-text -->
                                                                    @include('frontend.includes.product-promo-text',['manage_stock'=>$item->product->manage_stock, 'qty'=>$item->product->qty, 'in_stock'=>$item->product->in_stock, 'in_stock'=>$item->product->in_stock, 'current_date'=>date('Y-m-d') ,'new_to'=>$item->product->new_to])
                                                                <!--/ product-promo-text -->

                                                                <div class="product-overlay">
                                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#id_{{$item->product->id}}"> <span class="ti-zoom-in" data-bs-toggle="tooltip" data-bs-placement="top" title="quick view"></span></a>
                                                                    <a><span class="ti-heart add_to_wishlist" data-product_id="{{$item->product_id}}" data-product_slug="{{$item->product->slug}}" data-category_id="{{$item->category_id ?? null}}" data-qty="1" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('file.Add to wishlist')"></span></a>
                                                                </div>

                                                            </div>
                                                            <div class="product-details">
                                                                <a class="product-category" href="{{route('cartpro.category_wise_products',$item->category->slug)}}">{{$item->categoryTranslation->category_name ?? $item->categoryTranslationDefaultEnglish->category_name ?? NULL}}</a>
                                                                <a class="product-name" href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}">
                                                                    {{$item->productTranslation->product_name ?? $item->productTranslationDefaultEnglish->product_name ?? null}}
                                                                </a>

                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div>
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
                                                                        <div class="product-price">
                                                                            @if ($item->product->special_price!=NULL && $item->product->special_price>0 && $item->product->special_price<$item->product->price)
                                                                                <span class="promo-price">
                                                                                    @if(env('CURRENCY_FORMAT')=='suffix')
                                                                                        {{ number_format((float)$item->product->special_price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                                                    @else
                                                                                        @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->special_price  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
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
                                            @endif
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Product_Tab_1-Section_2 -->
                        <div class="tab-pane fade" id="{{$product_tabs_one_titles[1] ?? null}}" role="tabpanel" aria-labelledby="graphic-design-tab">
                            <div class="product-slider-wrapper swiper-container">
                                <div class="swiper-wrapper">
                                    @forelse ($product_tab_one_section_2 as $item)
                                            @if ($item->product!==NULL && $item->product->is_active==1)
                                                <div class="swiper-slide">
                                                    <form action="{{route('product.add_to_cart')}}" class="addToCart" method="post">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{$item->product_id}}">
                                                        <input type="hidden" name="product_slug" value="{{$item->product->slug}}">
                                                        <input type="hidden" name="category_id" value="{{$item->category_id ?? null}}">
                                                        <input type="hidden" name="qty" value="1">

                                                        <div class="single-product-wrapper">
                                                            <div class="single-product-item">
                                                                @if (isset($item->productBaseImage->image) && Illuminate\Support\Facades\File::exists(public_path($item->productBaseImage->image_medium)))
                                                                    <a href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}"><img class="swiper-lazy" data-src="{{asset('public/'.$item->productBaseImage->image_medium)}}"></a>
                                                                @else
                                                                    <a href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}"><img class="swiper-lazy" data-src="https://dummyimage.com/221.6x221.6/e5e8ec/e5e8ec&text=CartPro"></a>
                                                                @endif

                                                                <!-- product-promo-text -->
                                                                @include('frontend.includes.product-promo-text',['manage_stock'=>$item->product->manage_stock, 'qty'=>$item->product->qty, 'in_stock'=>$item->product->in_stock, 'in_stock'=>$item->product->in_stock, 'current_date'=>date('Y-m-d') ,'new_to'=>$item->product->new_to])
                                                                <!--/ product-promo-text -->

                                                                <div class="product-overlay">
                                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#id_{{$item->product->id}}"> <span class="ti-zoom-in" data-bs-toggle="tooltip" data-bs-placement="top" title="quick view"></span></a>
                                                                    <a><span class="ti-heart add_to_wishlist" data-product_id="{{$item->product_id}}" data-product_slug="{{$item->product->slug}}" data-category_id="{{$item->category_id ?? null}}" data-qty="1" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('file.Add to wishlist')"></span></a>
                                                                </div>

                                                            </div>
                                                            <div class="product-details">
                                                                <a class="product-category" href="{{route('cartpro.category_wise_products',$item->category->slug)}}">{{$item->categoryTranslation->category_name ?? $item->categoryTranslationDefaultEnglish->category_name ?? NULL}}</a>
                                                                <a class="product-name" href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}">
                                                                    {{$item->productTranslation->product_name ?? $item->productTranslationDefaultEnglish->product_name ?? null}}
                                                                </a>

                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div>
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
                                                                        <div class="product-price">
                                                                            @if ($item->product->special_price!=NULL && $item->product->special_price>0 && $item->product->special_price<$item->product->price)
                                                                                <span class="promo-price">
                                                                                    @if(env('CURRENCY_FORMAT')=='suffix')
                                                                                        {{ number_format((float)$item->product->special_price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                                                    @else
                                                                                        @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->special_price  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
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
                                            @endif
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Product_Tab_1-Section_3 -->
                        <div class="tab-pane fade" id="{{$product_tabs_one_titles[2] ?? null}}" role="tabpanel" aria-labelledby="graphic-design-tab">
                            <div class="product-slider-wrapper swiper-container">
                                <div class="swiper-wrapper">
                                    @forelse ($product_tab_one_section_3 as $item)
                                        @if ($item->product!==NULL && $item->product->is_active==1)
                                            <div class="swiper-slide">
                                                <form action="{{route('product.add_to_cart')}}" class="addToCart" method="post">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{$item->product_id}}">
                                                    <input type="hidden" name="product_slug" value="{{$item->product->slug}}">
                                                    <input type="hidden" name="category_id" value="{{$item->category_id ?? null}}">
                                                    <input type="hidden" name="qty" value="1">

                                                    <div class="single-product-wrapper">
                                                        <div class="single-product-item">
                                                            @if (isset($item->productBaseImage->image) && Illuminate\Support\Facades\File::exists(public_path($item->productBaseImage->image_medium)))
                                                                <a href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}"><img class="swiper-lazy" data-src="{{asset('public/'.$item->productBaseImage->image_medium)}}"></a>
                                                            @else
                                                                <a href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}"><img class="swiper-lazy" data-src="https://dummyimage.com/221.6x221.6/e5e8ec/e5e8ec&text=CartPro"></a>
                                                            @endif

                                                            <!-- product-promo-text -->
                                                            @include('frontend.includes.product-promo-text',['manage_stock'=>$item->product->manage_stock, 'qty'=>$item->product->qty, 'in_stock'=>$item->product->in_stock, 'in_stock'=>$item->product->in_stock, 'current_date'=>date('Y-m-d') ,'new_to'=>$item->product->new_to])
                                                            <!--/ product-promo-text -->

                                                            <div class="product-overlay">
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#id_{{$item->product->id}}"> <span class="ti-zoom-in" data-bs-toggle="tooltip" data-bs-placement="top" title="quick view"></span>
                                                                </a>
                                                                <a><span class="ti-heart add_to_wishlist" data-product_id="{{$item->product_id}}" data-product_slug="{{$item->product->slug}}" data-category_id="{{$item->category_id ?? null}}" data-qty="1" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('file.Add to wishlist')"></span></a>
                                                            </div>
                                                        </div>
                                                        <div class="product-details">
                                                            <a class="product-category" href="{{route('cartpro.category_wise_products',$item->category->slug)}}">{{$item->categoryTranslation->category_name ?? $item->categoryTranslationDefaultEnglish->category_name ?? NULL}}</a>
                                                            <a class="product-name" href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}">
                                                                {{$item->productTranslation->product_name ?? $item->productTranslationDefaultEnglish->product_name ?? NULL}}
                                                            </a>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
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
                                                                    <div class="product-price">
                                                                        @if ($item->product->special_price>0)
                                                                            <span class="promo-price">
                                                                                @if(env('CURRENCY_FORMAT')=='suffix')
                                                                                    {{ number_format((float)$item->product->special_price  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                                                @else
                                                                                    @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->special_price  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
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
                                        @endif
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Product_Tab_1-Section_4 -->
                        <div class="tab-pane fade" id="{{$product_tabs_one_titles[3] ?? null}}" role="tabpanel" aria-labelledby="graphic-design-tab">
                            <div class="product-slider-wrapper swiper-container">
                                <div class="swiper-wrapper">
                                    @forelse ($product_tab_one_section_4 as $item)
                                        @if ($item->product!==NULL && $item->product->is_active==1)
                                            <div class="swiper-slide">
                                                <form action="{{route('product.add_to_cart')}}" class="addToCart" method="post">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{$item->product_id}}">
                                                    <input type="hidden" name="product_slug" value="{{$item->product->slug}}">
                                                    <input type="hidden" name="category_id" value="{{$item->category_id ?? null}}">
                                                    <input type="hidden" name="qty" value="1">

                                                    <div class="single-product-wrapper">
                                                        <div class="single-product-item">
                                                            @if (isset($item->productBaseImage->image) && Illuminate\Support\Facades\File::exists(public_path($item->productBaseImage->image_medium)))
                                                                <a href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}"><img class="swiper-lazy" data-src="{{asset('public/'.$item->productBaseImage->image_medium)}}"></a>
                                                            @else
                                                                <a href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}"><img class="swiper-lazy" data-src="https://dummyimage.com/221.6x221.6/e5e8ec/e5e8ec&text=CartPro"></a>
                                                            @endif

                                                            <!-- product-promo-text -->
                                                            @include('frontend.includes.product-promo-text',['manage_stock'=>$item->product->manage_stock, 'qty'=>$item->product->qty, 'in_stock'=>$item->product->in_stock, 'in_stock'=>$item->product->in_stock, 'current_date'=>date('Y-m-d') ,'new_to'=>$item->product->new_to])
                                                            <!--/ product-promo-text -->

                                                            <div class="product-overlay">
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#id_{{$item->product->id}}"> <span class="ti-zoom-in" data-bs-toggle="tooltip" data-bs-placement="top" title="quick view"></span>
                                                                </a>
                                                                <a><span class="ti-heart add_to_wishlist" data-product_id="{{$item->product_id}}" data-product_slug="{{$item->product->slug}}" data-category_id="{{$item->category_id ?? null}}" data-qty="1" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('file.Add to wishlist')"></span></a>
                                                            </div>
                                                        </div>
                                                        <div class="product-details">
                                                            <a class="product-category" href="{{route('cartpro.category_wise_products',$item->category->slug)}}">{{$item->categoryTranslation->category_name ?? $item->categoryTranslationDefaultEnglish->category_name ?? NULL}}</a>
                                                            <a class="product-name" href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}">
                                                                {{$item->productTranslation->product_name ?? $item->productTranslationDefaultEnglish->product_name ?? NULL}}
                                                            </a>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
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
                                                                    <div class="product-price">
                                                                        @if ($item->product->special_price>0)
                                                                            <span class="promo-price">
                                                                                @if(env('CURRENCY_FORMAT')=='suffix')
                                                                                    {{ number_format((float)$item->product->special_price  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                                                @else
                                                                                    @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->special_price  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
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
                                                                    @endif                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    @forelse ($product_tab_one_section_1 as $item)
        @if ($item->product!==NULL && $item->product->is_active==1)
            @include('frontend.includes.quickshop')
        @endif
    @empty
    @endforelse

    @forelse ($product_tab_one_section_2 as $item)
        @if ($item->product!==NULL && $item->product->is_active==1)
            @include('frontend.includes.quickshop')
        @endif
    @empty
    @endforelse

    @forelse ($product_tab_one_section_3 as $item)
        @if ($item->product!==NULL && $item->product->is_active==1)
            @include('frontend.includes.quickshop')
        @endif
    @empty
    @endforelse

    @forelse ($product_tab_one_section_4 as $item)
        @if ($item->product!==NULL && $item->product->is_active==1)
            @include('frontend.includes.quickshop')
        @endif
    @empty
    @endforelse
@endif


<!--Two Coloumn Banner --->
@if ($two_column_banner_enabled==1)
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <a href="{{$settings_new['storefront_two_column_banners_1_call_to_action_url']->plain_value}}" target="{{$settings_new['storefront_two_column_banners_1_open_in_new_window']->plain_value==1 ? '__blank' : '' }}"><img class="lazy" data-src="{{asset($two_column_banner_image_1)}}" alt=""></a>
                </div>
                <div class="col-sm-6">
                    <a href="{{$settings_new['storefront_two_column_banners_2_call_to_action_url']->plain_value}}" target="{{$settings_new['storefront_two_column_banners_2_open_in_new_window']->plain_value==1 ? '__blank' : '' }}"><img class="lazy" data-src="{{asset($two_column_banner_image_2)}}" alt=""></a>
                </div>
            </div>
        </div>
    </section>
@endif

<!--Flash Sale And Vertical Products Start-->
@if ($flash_sale_and_vertical_products_section_enabled==1)
    <section>
        <div class="container">
            <div class="row">

                {{-- Flash Sale --}}
                <div class="col-md-12">
                    <div class="section-title mb-3">
                        <h3>
                            {{$storefront_flash_sale_title}}
                        </h3>
                    </div>
                    <div class="deals-slider-wrapper swiper-container mb-3">
                        <div class="swiper-wrapper">
                            @if ($flash_sales)
                                @forelse ($flash_sales->flashSaleProducts as $item)
                                    @if ($item->price >0 && $item->product->is_active==1)
                                        <div class="swiper-slide">
                                            <form action="{{route('product.add_to_cart')}}" class="addToCart" method="post">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{$item->product->id}}">
                                                <input type="hidden" name="product_slug" value="{{$item->product->slug}}">
                                                <input type="hidden" name="category_id" value="{{$item->product->categoryProduct[0]->category_id}}">
                                                <input type="hidden" name="flash_sale" value="1">
                                                <input type="hidden" name="flash_sale_price" value="{{$item->price}}">
                                                <input type="hidden" name="qty" value="1">

                                                <div class="single-product-wrapper deals">
                                                    <div class="single-product-item">
                                                        @if (isset($item->product->baseImage->image) && Illuminate\Support\Facades\File::exists(public_path($item->product->baseImage->image_medium)))
                                                            <a href="{{url('product/'.$item->product->slug.'/'. $item->product->categoryProduct[0]->category_id)}}"><img class="swiper-lazy" data-src="{{asset('public/'.$item->product->baseImage->image_medium)}}"></a>
                                                        @else
                                                            <a href="{{url('product/'.$item->product->slug.'/'. $item->product->categoryProduct[0]->category_id)}}"><img class="swiper-lazy" data-src="https://dummyimage.com/375x375/e5e8ec/e5e8ec&text=Best-Deals"></a>
                                                        @endif

                                                        <!-- product-promo-text -->
                                                        @include('frontend.includes.product-promo-text',['manage_stock'=>$item->product->manage_stock, 'qty'=>$item->product->qty, 'in_stock'=>$item->product->in_stock, 'in_stock'=>$item->product->in_stock, 'current_date'=>date('Y-m-d') ,'new_to'=>$item->product->new_to])
                                                        <!--/ product-promo-text -->

                                                        <div class="product-overlay">
                                                            {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#flash_sale_{{$item->product->slug ?? null}}"> <span class="ti-zoom-in" data-bs-toggle="tooltip" data-bs-placement="top" title="quick view"></span></a> --}}
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#id_{{$item->product->id}}"> <span class="ti-zoom-in" data-bs-toggle="tooltip" data-bs-placement="top" title="quick view"></span></a>
                                                            <a>
                                                                <span class="ti-heart add_to_wishlist" data-product_id="{{$item->product_id}}" data-product_slug="{{$item->product->slug}}" data-category_id="{{$item->product->categoryProduct[0]->category_id ?? null}}" data-qty="1" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('file.Add to wishlist')"></span>
                                                            </a>

                                                        </div>
                                                    </div>
                                                    <div class="product-details">
                                                        <a class="product-name text-center" href="{{url('product/'.$item->product->slug.'/'. $item->product->categoryProduct[0]->category_id)}}">
                                                            {{$item->product->productTranslation->product_name ?? null}}
                                                        </a>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
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
                                                                <div class="product-price">
                                                                    @if ($item->price>0 && $item->price<$item->product->price)
                                                                        <span class="promo-price">
                                                                            @if(env('CURRENCY_FORMAT')=='suffix')
                                                                                {{ number_format((float)$item->price  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                                            @else
                                                                                @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->price  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                                            @endif
                                                                        </span>
                                                                        <span class="old-price">
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
                                                        <div class="daily-deals-wrap">
                                                            <!-- countdown start -->
                                                            <div class="countdown-deals text-center" data-countdown="{{$item->end_date}}">
                                                                <div class="cdown day">
                                                                    <span class="time-count">00</span>
                                                                    <p>@lang('file.Days')</p>
                                                                </div>
                                                                <div class="cdown hour">
                                                                    <span class="time-count">00</span>
                                                                    <p>@lang('file.Hours')</p>
                                                                </div>
                                                                <div class="cdown minutes">
                                                                    <span class="time-count">00</span>
                                                                    <p>@lang('file.Mins')</p>
                                                                </div>
                                                                <div class="cdown second">
                                                                    <span class="time-count">00</span>
                                                                    <p>@lang('file.Secs')</p>
                                                                </div>
                                                            </div>
                                                            <!-- countdown end -->
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        @if ($item->qty>=0)
                                                            @lang('file.Available') {{$item->qty}}
                                                        @endif

                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                @empty
                                @endforelse
                            @endif
                        </div>
                        <!-- Add Pagination -->
                        <div class="deals-navigation">
                            <div class="deals-button-next"><i class="ti-angle-right"></i></div>
                            <div class="deals-button-prev"><i class="ti-angle-left"></i></div>
                        </div>
                    </div>
                </div>

                {{-- Verticle --}}
                <div class="col-md-12">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="section-title mb-3">
                                <h3>{{$storefront_vertical_product_1_title}}</h3>
                                <!-- Add Pagination -->
                                <div class="list-navigation">
                                    <div class="list-button-prev list-slider-1-arrow-prev"><i class="ti-angle-left"></i></div>
                                    <div class="list-button-next list-slider-1-arrow-next"><i class="ti-angle-right"></i></div>
                                </div>
                            </div>
                            <div class="list-slider-wrapper-1 swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        @forelse ($vertical_product_1 as $key => $item)
                                            @if ($key<3)
                                                @if ($item->product->is_active==1)
                                                    <form action="{{route('product.add_to_cart')}}" class="addToCart" method="post">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{$item->product_id}}">
                                                        <input type="hidden" name="product_slug" value="{{$item->product->slug}}">
                                                        <input type="hidden" name="category_id" value="{{$item->category_id ?? null}}">
                                                        <input type="hidden" name="qty" value="1">

                                                        <div class="single-product-wrapper list">
                                                            <div class="single-product-item">

                                                                @if (isset($item->productBaseImage->image) && Illuminate\Support\Facades\File::exists(public_path($item->productBaseImage->image_small)))
                                                                    <a href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}"><img class="swiper-lazy" data-src="{{asset('public/'.$item->productBaseImage->image_small)}}"></a>
                                                                @else
                                                                    <a href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}"><img class="swiper-lazy" data-src="https://dummyimage.com/375x375/e5e8ec/e5e8ec&text=CartPro"></a>
                                                                @endif

                                                            </div>
                                                            <div class="product-details">
                                                                <a class="product-name" href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}">
                                                                    {{$item->productTranslation->product_name ?? $item->productTranslationDefaultEnglish->product_name ?? null}}
                                                                </a>
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div>
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
                                                                        <div class="product-price">
                                                                            @if ($item->product->special_price>0)
                                                                                <span class="promo-price">
                                                                                    @if(env('CURRENCY_FORMAT')=='suffix')
                                                                                        {{ number_format((float)$item->product->special_price  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                                                    @else
                                                                                        @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->special_price  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
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
                                                @endif
                                            @endif
                                        @empty
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="section-title mb-3">
                                <h3>{{$storefront_vertical_product_2_title}}</h3>
                                <!-- Add Pagination -->
                                <div class="list-navigation">
                                    <div class="list-button-prev list-slider-2-arrow-prev"><i class="ti-angle-left"></i></div>
                                    <div class="list-button-next list-slider-2-arrow-next"><i class="ti-angle-right"></i></div>
                                </div>
                            </div>
                            <div class="list-slider-wrapper-2 swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        @forelse ($vertical_product_2 as $key => $item)
                                            @if ($key<3)
                                                @if ($item->product->is_active==1)
                                                    <form action="{{route('product.add_to_cart')}}" class="addToCart" method="post">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{$item->product_id}}">
                                                        <input type="hidden" name="product_slug" value="{{$item->product->slug}}">
                                                        <input type="hidden" name="category_id" value="{{$item->category_id ?? null}}">
                                                        <input type="hidden" name="qty" value="1">

                                                        <div class="single-product-wrapper list">
                                                            <div class="single-product-item">
                                                                @if (isset($item->productBaseImage->image) && Illuminate\Support\Facades\File::exists(public_path($item->productBaseImage->image)))
                                                                    <a href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}"><img class="swiper-lazy" data-src="{{asset('public/'.$item->productBaseImage->image)}}"></a>
                                                                @else
                                                                    <a href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}"><img class="swiper-lazy" data-src="https://dummyimage.com/375x375/e5e8ec/e5e8ec&text=CartPro"></a>
                                                                @endif


                                                            </div>
                                                            <div class="product-details">
                                                                <a class="product-name" href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}">
                                                                    {{$item->productTranslation->product_name ?? $item->productTranslationDefaultEnglish->product_name ?? null}}
                                                                </a>
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div>
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
                                                                        <div class="product-price">
                                                                            @if ($item->product->special_price>0)
                                                                                <span class="promo-price">
                                                                                    @if(env('CURRENCY_FORMAT')=='suffix')
                                                                                        {{ number_format((float)$item->product->special_price  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                                                    @else
                                                                                        @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->special_price  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
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
                                                @endif
                                            @endif
                                        @empty
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="section-title mb-3">
                                <h3><h3>{{$storefront_vertical_product_3_title}}</h3></h3>
                                <!-- Add Pagination -->
                                <div class="list-navigation">
                                    <div class="list-button-prev list-slider-3-arrow-prev"><i class="ti-angle-left"></i></div>
                                    <div class="list-button-next list-slider-3-arrow-next"><i class="ti-angle-right"></i></div>
                                </div>
                            </div>
                            <div class="list-slider-wrapper-3 swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        @forelse ($vertical_product_3 as $key => $item)
                                            @if ($key<3)
                                                @if ($item->product->is_active==1)
                                                    <form action="{{route('product.add_to_cart')}}" class="addToCart" method="post">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{$item->product_id}}">
                                                        <input type="hidden" name="product_slug" value="{{$item->product->slug}}">
                                                        <input type="hidden" name="category_id" value="{{$item->category_id ?? null}}">
                                                        <input type="hidden" name="qty" value="1">

                                                        <div class="single-product-wrapper list">
                                                            <div class="single-product-item">
                                                                @if (isset($item->productBaseImage->image) && Illuminate\Support\Facades\File::exists(public_path($item->productBaseImage->image)))
                                                                    <a href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}"><img class="swiper-lazy" data-src="{{asset('public/'.$item->productBaseImage->image)}}"></a>
                                                                @else
                                                                    <a href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}"><img class="swiper-lazy" data-src="https://dummyimage.com/375x375/e5e8ec/e5e8ec&text=CartPro"></a>
                                                                @endif

                                                            </div>
                                                            <div class="product-details">
                                                                <a class="product-name" href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}">
                                                                    {{$item->productTranslation->product_name ?? $item->productTranslationDefaultEnglish->product_name ?? null}}
                                                                </a>
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div>
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
                                                                        <div class="product-price">
                                                                            @if ($item->product->special_price>0)
                                                                                <span class="promo-price">
                                                                                    @if(env('CURRENCY_FORMAT')=='suffix')
                                                                                        {{ number_format((float)$item->product->special_price  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                                                    @else
                                                                                        @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->special_price  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
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
                                                @endif
                                            @endif
                                        @empty
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
    @if ($flash_sales)
        @forelse ($flash_sales->flashSaleProducts as $item )
            @include('frontend.includes.quickshop_flash_sale')
        @empty
        @endforelse
    @endif
@endif
<!--Flash Sale And Vertical Products End-->

<!--Three Coloumn Banner --->
@if ($three_column_banner_enabled==1)
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <a href="{{$settings_new['storefront_three_column_banners_1_call_to_action_url']->plain_value}}" target="{{$settings_new['storefront_three_column_banners_1_open_in_new_window']->plain_value==1 ? '__blank' : '' }}"><img class="lazy" data-src="{{asset($three_column_banners_image_1)}}" alt=""></a>
            </div>
            <div class="col-sm-4">
                <a href="{{$settings_new['storefront_three_column_banners_2_call_to_action_url']->plain_value}}" target="{{$settings_new['storefront_three_column_banners_2_open_in_new_window']->plain_value==1 ? '__blank' : '' }}"><img class="lazy" data-src="{{asset($three_column_banners_image_2)}}" alt=""></a>
            </div>
            <div class="col-sm-4">
                <a href="{{$settings_new['storefront_three_column_banners_3_call_to_action_url']->plain_value}}" target="{{$settings_new['storefront_three_column_banners_3_open_in_new_window']->plain_value==1 ? '__blank' : '' }}"><img class="lazy" data-src="{{asset($three_column_banners_image_3)}}" alt=""></a>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Trending Start-->
<section class="product-tab-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title mb-3">
                    <h3>{{__('file.Trending')}}</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="product-grid">
                @forelse ($order_details as $item)
                    @if ($item->product->is_active==1)
                        <form action="{{route('product.add_to_cart')}}" class="addToCart" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$item->product->id}}">
                            <input type="hidden" name="product_slug" value="{{$item->product->slug}}">
                            <input type="hidden" name="category_id" value="{{$item->product->categoryProduct[0]->category_id}}">
                            <input type="hidden" name="qty" value="1">

                            <div class="product-grid-item">
                                <div class="single-product-wrapper">
                                    <div class="single-product-item">
                                        <a class="product-name" href="{{url('product/'.$item->product->slug.'/'. $item->product->categoryProduct[0]->category_id)}}">
                                        @if (isset($item->product->baseImage->image) && Illuminate\Support\Facades\File::exists(public_path($item->product->baseImage->image_medium)))
                                            <img class="lazy" data-src="{{asset('public/'.$item->product->baseImage->image_medium)}}">
                                        @else
                                            <img class="lazy" data-src="https://dummyimage.com/375x375/e5e8ec/e5e8ec&text=CartPro">
                                        @endif
                                        </a>

                                        <!-- product-promo-text -->
                                        @include('frontend.includes.product-promo-text',['manage_stock'=>$item->product->manage_stock, 'qty'=>$item->product->qty, 'in_stock'=>$item->product->in_stock, 'in_stock'=>$item->product->in_stock, 'current_date'=>date('Y-m-d') ,'new_to'=>$item->product->new_to])
                                        <!--/ product-promo-text -->

                                        <div class="product-overlay">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#quickshopTrend_{{$item->product->slug}}"> <span class="ti-zoom-in" data-bs-toggle="tooltip" data-bs-placement="top" title="quick view"></span></a>
                                            <a><span class="ti-heart add_to_wishlist" data-product_id="{{$item->product_id}}" data-product_slug="{{$item->product->slug}}" data-category_id="{{$item->product->categoryProduct[0]->category_id ?? null}}" data-qty="1" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('file.Add to wishlist')"></span></a>
                                        </div>
                                    </div>
                                    <div class="product-details">
                                        <a class="product-category" href="{{route('cartpro.category_wise_products',$item->product->categoryProduct[0]->category->slug)}}">
                                            {{$item->product->categoryProduct[0]->category->catTranslation->category_name ?? NULL}}
                                        </a>
                                        <a class="product-name" href="{{url('product/'.$item->product->slug.'/'. $item->product->categoryProduct[0]->category_id)}}">
                                            {{$item->product->productTranslation->product_name ?? null}}
                                        </a>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
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
                                                <div class="product-price">
                                                    @if ($item->product->special_price!=NULL && $item->product->special_price>0 && $item->product->special_price<$item->product->price)
                                                        <span class="old-price">
                                                            @if(env('CURRENCY_FORMAT')=='suffix')
                                                                {{ number_format((float)$item->product->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                            @else
                                                                @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                            @endif
                                                        </span>
                                                        <span class="promo-price">
                                                            @if(env('CURRENCY_FORMAT')=='suffix')
                                                                {{ number_format((float)$item->product->special_price  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                            @else
                                                                @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->special_price  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                                            @endif
                                                        </span>
                                                    @else
                                                        <span class="promo-price">
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
                            </div>
                        </form>
                    @endif
                @empty
                @endforelse
            </div>
        </div>
    </div>
</section>
@forelse ($order_details as $item )
    @include('frontend.includes.quickshop_trending')
@empty
@endforelse
<!-- Trending ends-->


<!-- One Coloumn Banner --->
@if ($one_column_banner_enabled==1)
<section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a href="{{$settings_new['storefront_one_column_banner_call_to_action_url']->plain_value}}" target="{{$settings_new['storefront_one_column_banner_open_in_new_window']->plain_value==1 ? '__blank' : '' }}"><img class="lazy" data-src="{{asset($one_column_banner_image)}}" alt=""></a>
            </div>
        </div>
    </div>
</section>
@endif

<!--Brands-->
@if ($storefront_top_brands_section_enabled==1)
<section class="brand-tab-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="brand-slider-wrapper swiper-container">
                    <div class="swiper-wrapper">
                        @forelse ($brands as $brand)
                            <div class="swiper-slide">
                                <a class="brand-wrapper" href="{{route('cartpro.brand.products',$brand->slug)}}">
                                    @if($brand->brand_logo!==null && Illuminate\Support\Facades\File::exists(public_path($brand->brand_logo)))
                                        <img class="swiper-lazy" data-src="{{asset('public/'.$brand->brand_logo)}}" width="150px">
                                    @else
                                        <img class="swiper-lazy" data-src="https://dummyimage.com/100x100/e5e8ec/e5e8ec&text=Brand-Logo">
                                    @endif
                                </a>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
            <!-- Add Pagination -->
            <div class="brand-navigation">
                <div class="brand-button-next"><i class="ti-angle-right"></i></div>
                <div class="brand-button-prev"><i class="ti-angle-left"></i></div>
            </div>
        </div>
    </div>
</section>
@endif
<!--Brands-->


<!--Hero Promo Area starts--->
<div class="hero-promo-area v1">
    <div class="container">
        <div class="row">

            @if ($settings[18]->plain_value==1)
                <!-- Feature 1 -->
                <div class="col-md-3 col-6 single-promo-item style2 text-center">
                    <div class="promo-icon style2">
                        <i class="{{$settings[21]->plain_value ?? null }}"></i>
                    </div>
                    <div class="promo-content style2">
                        <h5>{{$settings[19]->settingTranslation->value ?? $settings[19]->settingTranslationDefaultEnglish->value ?? NULL }}</h5>
                        <span>{{$settings[20]->settingTranslation->value ?? $settings[19]->settingTranslationDefaultEnglish->value ?? NULL }}</span>
                    </div>
                </div>
                <!-- Feature 2 -->
                <div class="col-md-3 col-6 single-promo-item style2 text-center">
                    <div class="promo-icon style2">
                        <i class="{{$settings[24]->plain_value ?? null }}"></i>
                    </div>
                    <div class="promo-content style2">
                        <h5>{{$settings[22]->settingTranslation->value ?? $settings[22]->settingTranslationDefaultEnglish->value ?? NULL }}</h5>
                        <span>{{$settings[23]->settingTranslation->value ?? $settings[23]->settingTranslationDefaultEnglish->value ?? NULL }}</span>
                    </div>
                </div>
                <!-- Feature 3 -->
                <div class="col-md-3 col-6 single-promo-item style2 text-center">
                    <div class="promo-icon style2">
                        <i class="{{$settings[27]->plain_value ?? null }}"></i>
                    </div>
                    <div class="promo-content style2">
                        <h5>{{$settings[25]->settingTranslation->value ?? $settings[22]->settingTranslationDefaultEnglish->value ?? NULL }}</h5>
                        <span>{{$settings[26]->settingTranslation->value ?? $settings[23]->settingTranslationDefaultEnglish->value ?? NULL }}</span>
                    </div>
                </div>
                <!-- Feature 4 -->
                <div class="col-md-3 col-6 single-promo-item style2 text-center">
                    <div class="promo-icon style2">
                        <i class="{{$settings[30]->plain_value ?? null }}"></i>
                    </div>
                    <div class="promo-content style2">
                        <h5>{{$settings[28]->settingTranslation->value ?? $settings[28]->settingTranslationDefaultEnglish->value ?? NULL }}</h5>
                        <span>{{$settings[29]->settingTranslation->value ?? $settings[29]->settingTranslationDefaultEnglish->value ?? NULL }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection


@push('scripts')
    <script type="text/javascript">

        //for Product_Tab_1
        $('.attribute_value_productTab1').on("click",function(e){
            e.preventDefault();
            $(this).addClass('selected');

            var selectedVal = $(this).data('value_id');
            values.push(selectedVal);
            $('.value_ids_productTab1').val(values);
        });

        //for FlashSale
        $('.attribute_value_flashSale').on("click",function(e){
            e.preventDefault();
            $(this).addClass('selected');

            var selectedVal = $(this).data('value_id');
            values.push(selectedVal);
            $('.value_ids_flashSale').val(values);
        });

        //for Trending
        $('.attribute_value_trending').on("click",function(e){
            e.preventDefault();
            $(this).addClass('selected');

            var selectedVal = $(this).data('value_id');
            values.push(selectedVal);
            $('.value_ids_trending').val(values);
        });


        $('#star_1').on('click',function(){
            $('#star_1').removeClass('las la-star-outline').addClass('las la-star');
            $('#rating').val(1);

            $('#star_2').removeClass('las la-star').addClass('las la-star-outline');
            $('#star_3').removeClass('las la-star').addClass('las la-star-outline');
            $('#star_4').removeClass('las la-star').addClass('las la-star-outline');
            $('#star_5').removeClass('las la-star').addClass('las la-star-outline');
        })
        $('#star_2').on('click',function(){
            $('#star_1').removeClass('las la-star-outline').addClass('las la-star');
            $('#star_2').removeClass('las la-star-outline').addClass('las la-star');
            $('#rating').val(2);
            $('#star_3').removeClass('las la-star').addClass('las la-star-outline');
            $('#star_4').removeClass('las la-star').addClass('las la-star-outline');
            $('#star_5').removeClass('las la-star').addClass('las la-star-outline');
        })
        $('#star_3').on('click',function(){
            $('#star_1').removeClass('las la-star-outline').addClass('las la-star');
            $('#star_2').removeClass('las la-star-outline').addClass('las la-star');
            $('#star_3').removeClass('las la-star-outline').addClass('las la-star');
            $('#rating').val(3);
            $('#star_4').removeClass('las la-star').addClass('las la-star-outline');
            $('#star_5').removeClass('las la-star').addClass('las la-star-outline');
        })
        $('#star_4').on('click',function(){
            $('#star_1').removeClass('las la-star-outline').addClass('las la-star');
            $('#star_2').removeClass('las la-star-outline').addClass('las la-star');
            $('#star_3').removeClass('las la-star-outline').addClass('las la-star');
            $('#star_4').removeClass('las la-star-outline').addClass('las la-star');
            $('#rating').val(4);
            $('#star_5').removeClass('las la-star').addClass('las la-star-outline');
        })
        $('#star_5').on('click',function(){
            $('#star_1').removeClass('las la-star-outline').addClass('las la-star');
            $('#star_2').removeClass('las la-star-outline').addClass('las la-star');
            $('#star_3').removeClass('las la-star-outline').addClass('las la-star');
            $('#star_4').removeClass('las la-star-outline').addClass('las la-star');
            $('#star_5').removeClass('las la-star-outline').addClass('las la-star');
            $('#rating').val(5);
        })


    </script>
@endpush



