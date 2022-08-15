<!-- Sidebar-->
<nav class="side-navbar">
    <span class="brand-big" id="site_logo_main">
        @if(isset($setting_store->admin_logo) && Illuminate\Support\Facades\File::exists(public_path($setting_store->admin_logo)))
            <img src="{{asset('public/'.$setting_store->admin_logo)}}" width="150">
            &nbsp; &nbsp;
        @else
        <img src="https://dummyimage.com/150x150/e5e8ec/e5e8ec&text=Dashboard Logo" width="150">
            &nbsp; &nbsp;
        @endif
    </span>
    <!-- Sidebar Navigation Menus-->
    <ul id="side-main-menu" class="side-menu list-unstyled">
        <li><a href="{{url('/admin/dashboard')}}"> <i class="dripicons-meter"></i><span>{{__('file.Dashboard') }}</span></a></li>
        @can('product')
        <li class="has-dropdown"><a href="#product" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-cube"></i><span>{{__('file.Products')}}</span></a>
            <ul id="product" class="collapse list-unstyled ">
                @can('category')
                    <li id="category-menu"><a href="{{route('admin.category')}}">{{__('file.Category')}}</a></li>
                @endcan
                @can('brand')
                    <li id="brand-list-menu"><a href="{{route('admin.brand')}}">{{__('file.Brand')}}</a></li>
                @endcan
                @can('attribute_set')
                    <li id="brand-list-menu"><a href="{{route('admin.attribute_set.index')}}">{{__('file.Attribute_Set')}}</a></li>
                @endcan
                @can('attribute')
                    <li id="brand-list-menu"><a href="{{route('admin.attribute.index')}}">{{__('file.Attributes')}}</a></li>
                @endcan
                @can('tag')
                    <li id="brand-list-menu"><a href="{{route('admin.tag.index')}}">{{__('file.Tags')}}</a></li>
                @endcan
                @can('catalog')
                    <li id="brand-list-menu"><a href="{{route('admin.products.index')}}">{{__('file.Catalog')}}</a></li>
                @endcan
                <li id="brand-list-menu"><a href="{{route('admin.review.index')}}">{{__('file.Reviews')}}</a></li>
            </ul>
        </li>
        @endcan

        <li><a href="#sale" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-dollar"></i><span>{{__('file.Sales')}}</span></a>
            <ul id="sale" class="collapse list-unstyled">
              <li id="sale-list-menu"><a href="{{route('admin.order.index')}}">{{__('file.Orders')}}</a></li>
              <li id="sale-list-menu"><a href="{{route('admin.transaction.index')}}">{{__('file.Transactions')}}</a></li>
            </ul>
        </li>

        @can('flash_sale')
        <li><a href="{{route('admin.flash_sale.index')}}"><i class="fa fa-bolt"></i><span>{{__('file.Flash Sales')}}</span></a></li>
        @endcan

        @can('coupon')
        <li><a href="{{route('admin.coupon.index')}}"><i class="fa fa-tags"></i><span>{{__('file.Coupons')}}</span></a></li>
        @endcan
        <li><a href="#report" aria-expanded="false" data-toggle="collapse"> <i class="dripicons-document-remove"></i><span>{{__('file.Reports')}}</span></a>
            <ul id="report" class="collapse list-unstyled">
                <li><a href="{{route('admin.reports.coupon')}}">@lang('file.Coupon Report')</a></li>
                <li><a href="{{route('admin.reports.customer_orders')}}">@lang('file.Customer Order Report')</a></li>
                <li><a href="{{route('admin.reports.product_stock_report')}}">@lang('file.Product Stock Report')</a></li>
                <li><a href="{{route('admin.reports.product_view_report')}}">@lang('file.Product View Report')</a></li>
                <li><a href="{{route('admin.reports.sales_report')}}">@lang('file.Sales Report')</a></li>
                <li><a href="{{route('admin.reports.search_report')}}">@lang('file.Search Report')</a></li>
                <li><a href="{{route('admin.reports.shipping_report')}}">@lang('file.Shipping Report')</a></li>
                <li><a href="{{route('admin.reports.tax_report')}}">@lang('file.Tax Report')</a></li>
                {{-- <li><a href="{{route('admin.reports.product_purchase_report')}}">@lang('file.Product Purchase Report')</a></li> --}}
            </ul>
        </li>

        @can('appearance')
        <li><a href="#menu" aria-expanded="false" data-toggle="collapse"> <i class="dripicons-store"></i><span>{{trans('file.Online Store')}}</span></a>
            <ul id="menu" class="collapse list-unstyled">
                @can('page')
                <li><a href="{{route('admin.page.index')}}">{{trans('file.Pages')}}</a></li>
                @endcan
                @can('menu')
                <li><a href="{{route('admin.menu')}}">{{trans('file.Menus')}}</a></li>
                @endcan
                @can('store_front')
                    <li id="navigation-menu"><a href="{{route('admin.storefront')}}">{{__('file.Store Front')}}</a></li>
                @endcan
                {{-- @can('slider') --}}
                    <li><a href="{{route('admin.slider')}}"><span>{{__('file.Slider')}}</span></a></li>
                {{-- @endcan --}}
            </ul>
        </li>
        @endcan

        <li><a href="#faq" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-sticky-note"></i><span>{{trans('file.FAQ Setting')}}</span></a>
            <ul id="faq" class="collapse list-unstyled">
                <li><a href="{{route('admin.faq_type.index')}}">{{__('file.Type')}}</a></li>
                <li><a href="{{route('admin.faq.index')}}"><span>{{__('file.FAQ Set')}}</span></a></li>
            </ul>
        </li>

        <li><a href="#localization" aria-expanded="false" data-toggle="collapse"> <i class="dripicons-web"></i><span>{{__('file.Localization')}}</span></a>
            <ul id="localization" class="collapse list-unstyled">
                <li><a href="{{route('admin.tax.index')}}">{{__('file.Taxes')}}</a></li>
                <li><a href="{{route('languages.translations.index',Session::get('currentLocal'))}}">{{__('file.Translations')}}</a></li>
                <li><a href="{{route('admin.currency_rate.index')}}">{{__('file.Currency Rates')}}</a></li>
            </ul>
        </li>

        @can('users_and_roles')
        <li><a href="#user" aria-expanded="false" data-toggle="collapse"> <i class="dripicons-user-group"></i><span>{{__('file.Users and Roles')}}</span></a>
            <ul id="user" class="collapse list-unstyled">
            @can('user')
                <li id="navigation-menu"><a href="{{route('admin.user')}}">{{__('file.Users')}}</a></li>
            @endcan
            @can('role')
                <li id="navigation-menu"><a href="{{route('admin.role.index')}}">{{__('file.Roles')}}</a></li>
            @endcan
            </ul>
        </li>
        @endcan

        @can('site-setting')
        <li class="has-dropdown">
            <a href="#setting" aria-expanded="false" data-toggle="collapse"> <i class="dripicons-toggles"></i><span>{{trans('file.Site Settings')}}</span></a>
            <ul id="setting" class="collapse list-unstyled ">
                @can('country')
                    <li id="setting_list"><a href="{{route('admin.country.index')}}">{{__('file.Country')}}</a></li>
                @endcan
                @can('currency')
                    <li id="setting_list"><a href="{{route('admin.currency.index')}}">{{__('file.Currency')}}</a></li>
                @endcan
                @can('setting')
                    <li id="setting_list"><a href="{{route('admin.setting.index')}}">{{__('file.Setting')}}</a></li>
                @endcan
                @can('locale')
                    <li id="language"><a href="{{route('admin.setting.language')}}">{{__('file.Language')}}</a></li>
                @endcan
            </ul>
        </li>
        @endcan
    </ul>
</nav>
<!-- Sidebar-->
