@forelse ($cart_content as $item)
    <tr>
        <td class="cart-product">
            <div class="item-details">
                <a class="deleteCart" data-id="{{$item->rowId}}"><i class="ti-close"></i></a>
                <img src="{{asset('public/'.$item->options->image ?? null)}}" alt="...">
                <div class="">
                    <a href="{{url('product/'.$item->options->product_slug.'/'. $item->options->category_id)}}">
                        <h3 class="h6">{{$item->name}}</h3>
                    </a>
                    <div class="input-qty">
                        <span class="input-group-btn">
                            <button type="button" class="quantity-left-minus">
                                <span class="ti-minus"></span>
                            </button>
                        </span>
                        <input type="text" class="input-number" value="{{$item->qty}}">
                        <span class="input-group-btn">
                            <button type="button" class="quantity-right-plus">
                                <span class="ti-plus"></span>
                            </button>
                        </span>
                    </div>
                    X
                    <span class="amount">
                        @if(env('CURRENCY_FORMAT')=='suffix')
                            {{$item->price}} {{env('DEFAULT_CURRENCY_SYMBOL')}}
                        @else
                            {{env('DEFAULT_CURRENCY_SYMBOL')}} {{$item->price}}
                        @endif
                    </span>
                </div>
            </div>
            <div class="cart-amount-mobile">@lang('file.Total')
                <span class="amount">
                    $90.00
                </span>
            </div>
        </td>
        <td class="cart-product-subtotal">
            <span class="amount">
                @if(env('CURRENCY_FORMAT')=='suffix')
                    {{$item->subtotal}} {{env('DEFAULT_CURRENCY_SYMBOL')}}
                @else
                    {{env('DEFAULT_CURRENCY_SYMBOL')}} {{$item->subtotal}}
                @endif
            </span>
        </td>
    </tr>
@empty
@endforelse
