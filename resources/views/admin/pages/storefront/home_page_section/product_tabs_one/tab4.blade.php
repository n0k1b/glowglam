<h4 class="mt-3 text-bold">{{__('file.Tab - 4')}}</h4><br>
<div class="form-group row">
    <label class="col-sm-4 col-form-label"><b>@lang('file.Title')</b></label>
    <div class="col-sm-8">
        <!-- DB_ROW_ID-98:  => setting[97] -->
        <input type="text" name="storefront_product_tabs_1_section_tab_4_title" class="form-control" placeholder="@lang('file.Title')"
        @forelse ($setting[97]->settingTranslations as $key => $item)
            @if ($item->locale==$locale)
                value="{{$item->value}}" @break
            @elseif($item->locale=='en')
                value="{{$item->value}}" @break
            @endif
        @empty
        @endforelse >
    </div>
</div>
<div class="form-group row d-none">
    <label class="col-sm-4 col-form-label"><b>@lang('file.Type')</b></label>
    <!-- DB_ROW_ID-99:  => setting[98] -->
    <div class="col-sm-8">
        <select name="storefront_product_tabs_1_section_tab_4_product_type" id="storefrontProductTabs_1_SectionTab_4_ProductType" class="form-control" data-live-search="true" data-live-search-style="begins">
            <option value="">@lang('file.-- Select Type --')</option>
            <option value="{{__('category_products')}}" selected>{{__('Category Products')}}</option>
        </select>
    </div>
</div>
@if ((!empty($setting[98]->plain_value)) && ($setting[98]->plain_value == 'category_products'))
    <div class="form-group row" id="categoryFeild_4">
        <label class="col-sm-4 col-form-label"><b>@lang('file.Category')</b></label>
        <div class="col-sm-8">
            <!-- DB_ROW_ID-90:  => setting[90] -->
            <select name="storefront_product_tabs_1_section_tab_4_category_id" id="storefrontProductTabs_1_SectionTab_4_CategoryId" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('file.Select Category')}}'>
                @foreach ($categories as $item)
                    @forelse ($item->categoryTranslation as $key => $value)
                        @if ($value->local==$locale)
                            <option value="{{$item->id}}" {{ $setting[99]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                        @elseif($value->local=='en')
                            <option value="{{$item->id}}" {{ $setting[99]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                        @endif
                    @empty
                        <option value="">{{__('NULL')}}</option>
                    @endforelse
                @endforeach
            </select>
        </div>
    </div>
@else
    <div class="form-group row" id="categoryFeild_4">
        <label class="col-sm-4 col-form-label"><b>@lang('file.Category')</b></label>
        <div class="col-sm-8">
            <!-- DB_ROW_ID-100:  => setting[99] -->
            <select name="storefront_product_tabs_1_section_tab_4_category_id" id="storefrontProductTabs_1_SectionTab_4_CategoryId" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('file.Select Category')}}'>
                @foreach ($categories as $item)
                    @forelse ($item->categoryTranslation as $key => $value)
                        @if ($value->local==$locale)
                            <option value="{{$item->id}}" {{ $setting[99]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                        @elseif($value->local=='en')
                            <option value="{{$item->id}}" {{ $setting[99]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                        @endif
                    @empty
                        <option value="">{{__('NULL')}}</option>
                    @endforelse
                @endforeach
            </select>
        </div>
    </div>
@endif

<div class="form-group row" id="productTabsField_4">
    @if ((!empty($setting[98]->plain_value)) && ($setting[98]->plain_value == 'custom_products'))
        <label class="col-sm-4 col-form-label"><b> {{__('file.Products')}}</b></label>
        <!-- DB_ROW_ID-101:  => setting[101] -->
        <div class="col-sm-8">
            <input type="text" name="storefront_product_tabs_1_section_tab_4_products" value="{{$setting[100]->plain_value}}" class="form-control">
        </div>
    @elseif((!empty($setting[98]->plain_value)) && (($setting[98]->plain_value == 'latest_products') || ($setting[98]->plain_value == 'recently_viewed_products')))
        <label class="col-sm-4 col-form-label"><b> {{__('file.Products Limit')}}</b></label>
        <!-- DB_ROW_ID-102:  => setting[101] -->
        <div class="col-sm-8">
            <input type="text" name="storefront_product_tabs_1_section_tab_4_products_limit" value="{{$setting[101]->plain_value}}" class="form-control">
        </div>
    @endif
</div>





