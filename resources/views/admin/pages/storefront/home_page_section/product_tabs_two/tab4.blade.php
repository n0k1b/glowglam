<h4 class="mt-3 text-bold">{{__('Tab - 4')}}</h4><br>
<div class="form-group row">
    <label class="col-sm-4 col-form-label"><b>Title</b></label>
    <div class="col-sm-8">
        <!-- DB_ROW_ID-120:  => setting[119] -->
        <input type="text" name="storefront_product_tabs_2_section_tab_4_title" class="form-control" placeholder="Type Title"
        @forelse ($setting[119]->settingTranslations as $key => $item)
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
    <!-- DB_ROW_ID-99121:  => setting[120] -->
    <div class="col-sm-8">
        <select name="storefront_product_tabs_2_section_tab_4_product_type" id="storefrontProductTabs_2_SectionTab_4_ProductType" class="form-control" data-live-search="true" data-live-search-style="begins">
            <option value="">-- Select Type --</option>
            <option value="{{__('category_products')}}" {{ $setting[120]->plain_value == 'category_products' ? 'selected="selected"' : '' }}>{{__('Category Products')}}</option>
            <option value="{{__('custom_products')}}" {{ $setting[120]->plain_value == 'custom_products' ? 'selected="selected"' : '' }}>{{__('Custom Products')}}</option>
            <option value="{{__('latest_products')}}" {{ $setting[120]->plain_value == 'latest_products' ? 'selected="selected"' : '' }}>{{__('Latest Products')}}</option>
            <option value="{{__('recently_viewed_products')}}" {{ $setting[120]->plain_value == 'recently_viewed_products' ? 'selected="selected"' : '' }}>{{__('Recently Viewed Products')}}</option>
        </select>
    </div>
</div>
@if ((!empty($setting[120]->plain_value)) && ($setting[120]->plain_value == 'category_products'))
    <div class="form-group row" id="tabTwoCategoryFeild_4">
        <label class="col-sm-4 col-form-label"><b>Category</b></label>
        <div class="col-sm-8">
            <!-- DB_ROW_ID-112:  => setting[121] -->
            <select name="storefront_product_tabs_2_section_tab_4_category_id" id="storefrontProductTabs_2_SectionTab_4_CategoryId" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('Select Category')}}'>
                @foreach ($categories as $item)
                    @forelse ($item->categoryTranslation as $key => $value)
                        @if ($value->local==$locale)
                            <option value="{{$item->id}}" {{ $setting[121]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                        @elseif($value->local=='en')
                            <option value="{{$item->id}}" {{ $setting[121]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                        @endif
                    @empty
                        <option value="">{{__('NULL')}}</option>
                    @endforelse
                @endforeach
            </select>
        </div>
    </div>
@else
    <div class="form-group row" id="tabTwoCategoryFeild_4">
        <label class="col-sm-4 col-form-label"><b>Category</b></label>
        <div class="col-sm-8">
            <!-- DB_ROW_ID-100:  => setting[121] -->
            <select name="storefront_product_tabs_2_section_tab_4_category_id" id="storefrontProductTabs_2_SectionTab_4_CategoryId" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('Select Category')}}'>
                @foreach ($categories as $item)
                    @forelse ($item->categoryTranslation as $key => $value)
                        @if ($value->local==$locale)
                            <option value="{{$item->id}}" {{ $setting[121]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                        @elseif($value->local=='en')
                            <option value="{{$item->id}}" {{ $setting[121]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                        @endif
                    @empty
                        <option value="">{{__('NULL')}}</option>
                    @endforelse
                @endforeach
            </select>
        </div>
    </div>
@endif

<div class="form-group row" id="tabTwoProductTabsField_4">
    @if ((!empty($setting[120]->plain_value)) && ($setting[120]->plain_value == 'custom_products'))
        <label class="col-sm-4 col-form-label"><b> {{__('Products')}}</b></label>
        <!-- DB_ROW_ID-123:  => setting[120] -->
        <div class="col-sm-8">
            <input type="text" name="storefront_product_tabs_2_section_tab_4_products" value="{{$setting[122]->plain_value}}" class="form-control">
        </div>
    @elseif((!empty($setting[120]->plain_value)) && (($setting[120]->plain_value == 'latest_products') || ($setting[120]->plain_value == 'recently_viewed_products')))
        <label class="col-sm-4 col-form-label"><b> {{__('Products Limit')}}</b></label>
        <!-- DB_ROW_ID-102:  => setting[101] -->
        <div class="col-sm-8">
            <input type="text" name="storefront_product_tabs_2_section_tab_4_products_limit" value="{{$setting[123]->plain_value}}" class="form-control">
        </div>
    @endif
</div>





