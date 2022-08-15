@extends('frontend.layouts.master')

@section('title','Wishlist')

@section('frontend_content')

    <!--Breadcrumb Area start-->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <ul>
                        <li><a href="home.html">@lang('file.Home')</a></li>
                        <li class="active">@lang('file.Shop Wishlist')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb Area ends-->

    <!-- wishlist section start-->
    <section class="wishlist-section">
        <div class="container">
            <div class="row">
                <h1 class="page-title h2 text-center uppercase mt-1 mb-5">@lang('file.Wishlist')</h1>
            </div>
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="table-content table-responsive cart-table wishlist">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>@lang('file.Product')</th>
                                    <th class="text-center">@lang('file.Price')</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <div id="wishlistContent">
                                    @forelse ($wishlists as $item)

                                        <tr id="wishlist_{{$item->id}}">
                                            <form class="addToCart">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{$item->product_id}}">
                                                <input type="hidden" name="product_slug" value="{{$item->product->slug}}">
                                                <input type="hidden" name="category_id" value="{{$item->category_id ?? null}}">
                                                <input type="hidden" name="qty" value="1">
                                                <input type="hidden" name="wishlist_id" value="{{$item->id}}">

                                                <td class="cart-product">
                                                    <div class="item-details">
                                                        <a class="remove_wishlist" data-id="{{$item->id}}"><i class="ti-close"></i></a>
                                                        <img class="lazy" data-src="{{asset('public/'.$item->product->baseImage->image ?? null)}}" alt="...">
                                                        <div class="">
                                                            <a href="{{url('product/'.$item->product->slug.'/'. $item->category_id)}}">
                                                                <h3 class="h6">{{$item->product->productTranslation->product_name}}</h3>
                                                            </a>

                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="cart-product-subtotal">
                                                    <span class="amount">
                                                        @if(env('CURRENCY_FORMAT')=='suffix')
                                                            @if ($item->product->special_price>0 && ($item->product->special_price < $item->product->price))
                                                                {{number_format((float)$item->product->special_price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '')}} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')
                                                            @else
                                                                {{number_format((float)$item->product->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '')}} @include('frontend.includes.SHOW_CURRENCY_SYMBOL')

                                                            @endif
                                                        @else
                                                            @if ($item->product->special_price>0 && ($item->product->special_price < $item->product->price))
                                                                @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->special_price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '')}}
                                                            @else
                                                                @include('frontend.includes.SHOW_CURRENCY_SYMBOL') {{ number_format((float)$item->product->price * $CHANGE_CURRENCY_RATE, env('FORMAT_NUMBER'), '.', '')}}
                                                            @endif
                                                        @endif
                                                    </span></td>
                                                <td>
                                                    <button class="button style1 button-icon" type="submit">{{__('file.Add to cart')}}</button>
                                                    {{-- <a class="button style1 button-icon"><span></span></a></td> --}}
                                            </form>
                                        </tr>
                                    @empty
                                </div>

                                @endforelse

                            </tbody>
                        </table>

                        <a href="shop-fullwidth.html" class="button style3"><i class="ti-arrow-left"></i> @lang('file.Continue Shopping')</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- wishlist section ends-->
@endsection

@push('scripts')

<script type="text/javascript">
    $(document).on('click','.remove_wishlist',function(event) {
        event.preventDefault();
        var wishlist_id = $(this).data('id');
        // var removeCartItemId = $(this).parent().parent().attr('id');

        $.ajax({
            url: "{{ route('wishlist.remove') }}",
            type: "GET",
            data: {wishlist_id:wishlist_id},
            success: function (data) {
                console.log(data);
                if (data.type=='success') {
                    $('#wishlist_'+wishlist_id).remove();
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
                        title: data.message
                    })
                }
                $('.wishlist_count').text(data.wishlist_count);
            }
        })
    });
</script>

@endpush


