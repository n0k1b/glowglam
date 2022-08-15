<div class="col-md-12 tabs style2 mb-5">
    <ul class="nav nav-tabs mar-top-30 product-details-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{Request::routeIs('user_account') ? 'active' : ''  }}" href="{{route('user_account')}}">@lang('file.Dashboard')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{Request::routeIs('user.order.history') ? 'active' : ''  }}" href="{{route('user.order.history')}}">@lang('file.Orders')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{Request::routeIs('billing_addrees.index') ? 'active' : ''  }}" href="{{route('billing_addrees.index')}}">@lang('file.Set Billing Address')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{Request::routeIs('shipping_addrees.index') ? 'active' : ''  }}" href="{{route('shipping_addrees.index')}}">@lang('file.Set Shipping Address')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('wishlist.index')}}">@lang('file.Wishlist')</a>
        </li>
        <li>
            <form action="{{route('user_logout')}}" method="post">
                @csrf
                <button class="btn btn-text nav-link" data-toggle="tab" role="tab" aria-controls="graphic_design" aria-selected="false" type="submit">{{__('file.logout')}}</button>
            </form>
        </li>
    </ul>
</div>
