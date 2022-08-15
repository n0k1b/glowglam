<h4 class="mt-3 text-bold">{{__('Tab - 2')}}</h4><br>
<div class="form-group row">
    <label class="col-sm-4 col-form-label"><b>Title</b></label>
    <div class="col-sm-8">
        <!-- DB_ROW_ID-110:  => setting[109] -->
        <input type="text" name="storefront_product_tabs_2_section_tab_2_title" class="form-control" placeholder="Type Title"
        @forelse ($setting[109]->settingTranslations as $key => $item)
            @if ($item->locale==$locale)
                value="{{$item->value}}" @break
            @elseif($item->locale=='en')
                value="{{$item->value}}" @break
            @endif
        @empty
        @endforelse >
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-4 col-form-label"><b>Type</b></label>
    <!-- DB_ROW_ID-111:  => setting[110] -->
    <div class="col-sm-8">
        <select name="storefront_product_tabs_2_section_tab_2_product_type" id="storefrontProductTabs_2_SectionTab_2_ProductType" class="form-control" data-live-search="true" data-live-search-style="begins">
            <option value="">-- Select Type --</option>
            <option value="{{__('category_products')}}" {{ $setting[110]->plain_value == 'category_products' ? 'selected="selected"' : '' }}>{{__('Category Products')}}</option>
            <option value="{{__('custom_products')}}" {{ $setting[110]->plain_value == 'custom_products' ? 'selected="selected"' : '' }}>{{__('Custom Products')}}</option>
            <option value="{{__('latest_products')}}" {{ $setting[110]->plain_value == 'latest_products' ? 'selected="selected"' : '' }}>{{__('Latest Products')}}</option>
            <option value="{{__('recently_viewed_products')}}" {{ $setting[110]->plain_value == 'recently_viewed_products' ? 'selected="selected"' : '' }}>{{__('Recently Viewed Products')}}</option>
        </select>
    </div>
</div>
@if ((!empty($setting[110]->plain_value)) && ($setting[110]->plain_value == 'category_products'))
    <div class="form-group row" id="tabTwoCategoryFeild_2">
        <label class="col-sm-4 col-form-label"><b>Category</b></label>
        <div class="col-sm-8">
            <!-- DB_ROW_ID-112:  => setting[112] -->
            <select name="storefront_product_tabs_2_section_tab_2_category_id" id="storefrontProductTabs_2_SectionTab_2_CategoryId" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('Select Category')}}'>
                @foreach ($categories as $item)
                    @forelse ($item->categoryTranslation as $key => $value)
                        @if ($value->local==$locale)
                            <option value="{{$item->id}}" {{ $setting[111]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                        @elseif($value->local=='en')
                            <option value="{{$item->id}}" {{ $setting[111]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                        @endif
                    @empty
                        <option value="">{{__('NULL')}}</option>
                    @endforelse
                @endforeach
            </select>
        </div>
    </div>
@else
    <div class="form-group row" id="tabTwoCategoryFeild_2">
        <label class="col-sm-4 col-form-label"><b>Category</b></label>
        <div class="col-sm-8">
            <!-- DB_ROW_ID-112:  => setting[111] -->
            <select name="storefront_product_tabs_2_section_tab_2_category_id" id="storefrontProductTabs_2_SectionTab_2_CategoryId" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('Select Category')}}'>
                @foreach ($categories as $item)
                    @forelse ($item->categoryTranslation as $key => $value)
                        @if ($value->local==$locale)
                            <option value="{{$item->id}}" {{ $setting[111]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                        @elseif($value->local=='en')
                            <option value="{{$item->id}}" {{ $setting[111]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                        @endif
                    @empty
                        <option value="">{{__('NULL')}}</option>
                    @endforelse
                @endforeach
            </select>
        </div>
    </div>
@endif

<div class="form-group row" id="tabTwoProductTabsField_2">
    @if ((!empty($setting[110]->plain_value)) && ($setting[110]->plain_value == 'custom_products'))
        <label class="col-sm-4 col-form-label"><b> {{__('Products')}}</b></label>
        <!-- DB_ROW_ID-113:  => setting[112] -->
        <div class="col-sm-8">
            <input type="text" name="storefront_product_tabs_2_section_tab_2_products" value="{{$setting[112]->plain_value}}" class="form-control">
        </div>
    @elseif((!empty($setting[110]->plain_value)) && (($setting[110]->plain_value == 'latest_products') || ($setting[110]->plain_value == 'recently_viewed_products')))
        <label class="col-sm-4 col-form-label"><b> {{__('Products Limit')}}</b></label>
        <!-- DB_ROW_ID-114:  => setting[13] -->
        <div class="col-sm-8">
            <input type="text" name="storefront_product_tabs_2_section_tab_2_products_limit" value="{{$setting[113]->plain_value}}" class="form-control">
        </div>
    @endif
</div>
