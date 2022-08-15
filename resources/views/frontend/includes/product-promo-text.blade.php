@if (($manage_stock==1 && $qty==0) || ($in_stock==0))
    <div class="product-promo-text style1 bg-danger">
        <span>@lang('file.Stock Out')</span>
    </div>
@elseif ($current_date <= $new_to)
    <div class="product-promo-text style1">
        <span>@lang('file.New')</span>
    </div>
@endif

<!-- product-promo-text -->
{{-- @include('frontend.includes.product-promo-text',['manage_stock'=>$item->product->manage_stock, 'qty'=>$item->product->qty, 'in_stock'=>$item->product->in_stock, 'in_stock'=>$item->product->in_stock, 'current_date'=>date('Y-m-d') ,'new_to'=>$item->product->new_to]) --}}
<!--/ product-promo-text -->
