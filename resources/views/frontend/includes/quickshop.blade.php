    <!-- Quick Shop Modal starts -->
    <div class="modal fade quickshop" id="id_{{$item->product->id}}" tabindex="-1" role="dialog" aria-labelledby="{{$item->product->id}}" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="las la-times"></i></span>
                    </button>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="slider-wrapper">
                                <div class="slider-for-modal">
                                    @forelse ($item->additionalImage as $value)
                                        <div class="slider-for__item ex1">
                                            <img class="lazy" data-src="{{asset('public/'.$value->image)}}" alt="..." />
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                                <div class="slider-nav-modal">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form action="{{route('product.add_to_cart')}}" class="addToCart" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="{{$item->product_id}}">
                                <input type="hidden" name="product_slug" value="{{$item->product->slug}}">
                                <input type="hidden" name="category_id" value="{{$item->category_id ?? null}}">
                                <input type="hidden" name="qty" value="1">
                                <input type="hidden" name="value_ids" class="value_ids_products">

                                <div class="item-details">
                                    <a class="item-category" href="">{{$item->categoryTranslation->category_name ?? $item->categoryTranslationDefaultEnglish->category_name ?? null}}</a>
                                    <h3 class="item-name">{{$item->productTranslation->product_name ?? $item->productTranslationDefaultEnglish->product_name ?? null}}</h3>
                                    <div class="d-flex justify-content-between">
                                        <div class="item-brand">@lang('file.Brand'): <a href="">{{$item->product->brand->brandTranslation->brand_name ?? $item->product->brand->brandTranslationDefaultEnglish->brand_name ?? null}}</a></div>
                                        <div class="item-review">
                                            <ul class="p-0 m-0">
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
                                            <span>( {{round($item->product->avg_rating)}} )</span>
                                        </div>
                                        @if ($item->product->sku)
                                            <div class="item-sku">@lang('file.SKU'): {{$item->product->sku ?? null}}</div>
                                        @endif
                                    </div>
                                    <hr>
                                    @if ($item->product->special_price!=NULL && $item->product->special_price>0 && $item->product->special_price<$item->product->price)
                                        <div class="item-price">
                                            @if(env('CURRENCY_FORMAT')=='suffix')
                                                {{ number_format((float)$item->product->special_price  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                            @else
                                                @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->special_price  * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '') }}
                                            @endif
                                            <hr>
                                            @if(env('CURRENCY_FORMAT')=='suffix')
                                                <small class="old-price"><del>{{ number_format((float)$item->product->price, env('FORMAT_NUMBER'), '.', '') }} {{env('DEFAULT_CURRENCY_SYMBOL')}} </del></small>
                                            @else
                                                <small class="old-price"><del>{{env('DEFAULT_CURRENCY_SYMBOL')}} {{ number_format((float)$item->product->price, env('FORMAT_NUMBER'), '.', '') }} </del></small>
                                            @endif
                                        </div>
                                    @else
                                        <div class="item-price">
                                            @if(env('CURRENCY_FORMAT')=='suffix')
                                                {{ number_format((float)$item->product->price, env('FORMAT_NUMBER'), '.', '') }} {{env('DEFAULT_CURRENCY_SYMBOL')}}
                                            @else
                                                {{env('DEFAULT_CURRENCY_SYMBOL')}} {{ number_format((float)$item->product->price, env('FORMAT_NUMBER'), '.', '') }}
                                            @endif
                                        </div>
                                    @endif

                                    <div class="item-short-description">
                                        <p>{{$item->productTranslation->short_description ?? $item->productTranslationDefaultEnglish->short_description ?? null}}</p>
                                    </div>
                                    <hr>
                                    @php
                                    $attribute = [];
                                        if ($item->productAttributeValues!=[]) {
                                            foreach ($item->productAttributeValues as $value) {
                                            $attribute[$value->attribute_id]= $value->attributeTranslation->attribute_name ?? $value->attributeTranslationEnglish->attribute_name ?? null;
                                            }
                                        }
                                    @endphp
                                    @forelse ($attribute as $key => $value)
                                        <div class="item-variant">
                                            <span>{{$value}}:</span>
                                            <input type="hidden" name="attribute_name[]" class="attribute_name" value="{{$value}}">
                                            <ul class="product-variant size-opt p-0 mt-1">
                                                @forelse ($item->productAttributeValues as $value)
                                                    @if ($value->attribute_id == $key)
                                                        <li class="attribute_value_productTab1" data-attribute_name="{{$value->attributeTranslation->attribute_name ?? $value->attributeTranslationEnglish->attribute_name ?? null }}" data-value_id="{{$value->attribute_value_id}}" data-value_name="{{$value->attrValueTranslation->value_name ?? $value->attrValueTranslationEnglish->value_name ?? null }}"><span>{{$value->attrValueTranslation->value_name ?? $value->attrValueTranslationEnglish->value_name ?? null }}</span></li>
                                                        <input type="hidden" name="value_id[]" value="{{$value->attribute_value_id}}">
                                                    @endif
                                                @empty
                                                @endforelse
                                            </ul>
                                        </div>
                                    @empty
                                    @endforelse

                                    <div class="item-options">
                                        <div class="input-qty">
                                            <span class="input-group-btn">
                                                <button type="button" class="quantity-left-minus decrementProductQty-{{$item->product->id}}">
                                                    <span class="ti-minus"></span>
                                                </button>
                                            </span>
                                            @if (($item->product->manage_stock==1 && $item->product->qty==0) || ($item->product->in_stock==0))
                                                <input type="number" name="qty" required class="input-number quantity-{{$item->product->id}}" value="1" min="1" max="0">
                                            @else
                                                <input type="number" name="qty" required class="input-number quantity-{{$item->product->id}}" value="1" min="1" max="{{$item->product->qty}}">
                                            @endif
                                            <span class="input-group-btn">
                                                <button type="button" class="quantity-right-plus incrementProductQty-{{$item->product->id}}">
                                                    <span class="ti-plus"></span>
                                                </button>
                                            </span>
                                        </div>
                                        @if (($item->product->manage_stock==1 && $item->product->qty==0) || ($item->product->in_stock==0))
                                            <button disabled title="Out of stock" data-bs-toggle="tooltip" data-bs-placement="top" class="button button-icon style1"><span><i class="las la-shopping-cart"></i> <span>@lang('file.Add to Cart')</span></span></button>
                                        @else
                                            <button type="submit" class="button button-icon style1"><span><i class="las la-shopping-cart"></i> <span>@lang('file.Add to Cart')</span></span></button>
                                        @endif
                                        <a><div class="button button-icon style4 sm @auth add_to_wishlist @else forbidden_wishlist @endauth" data-product_id="{{$item->product->id}}" data-product_slug="{{$item->product->slug}}" data-category_id="{{$item->product->categoryProduct[0]->category_id ?? null}}" data-qty="1"><p><span><i class="ti-heart"></i> </span>@lang('file.Add to Wishlist')</p></div></a>
                                    </div>

                                    <hr>
                                    <div class="item-share mt-3" id="social-links"><span>@lang('file.Share')</span>
                                        <ul class="footer-social d-inline pad-left-15">
                                            <li><a href="{{$socialShare['facebook']}}"><i class="ti-facebook"></i></a></li>
                                            <li><a href="{{$socialShare['twitter']}}"><i class="ti-twitter"></i></a></li>
                                            <li><a href="{{$socialShare['linkedin']}}"><i class="ti-linkedin"></i></a></li>
                                            <li><a href="{{$socialShare['reddit']}}"><i class="ti-reddit"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Quick shop modal ends-->



@push('scripts')
    <script type="text/javascript">
        //Quantity Manage in Modal
        $(".decrementProductQty-{{$item->product->id}}").on("click",function(e){
            $(".decrementProductQty-{{$item->product->id}}").prop("disabled",false);
        });
        $(".incrementProductQty-{{$item->product->id}}").on("click",function(e){
            var inputNumber = $('.quantity-{{$item->product->id}}').val();
            var maxNumber = $('.quantity-{{$item->product->id}}').attr('max');
            console.log(maxNumber);

            if (maxNumber==0) {
                console.log(Number(maxNumber));
            }else{
                if ((Number(inputNumber)+1) > Number(maxNumber)) {
                    $('.quantity-{{$item->product->id}}').val(Number(maxNumber)-1);
                    $(this).prop("disabled",true);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Available product is : '+ maxNumber,
                    });
                }
            }
        });
    </script>
@endpush

