<h4 class="mt-3 text-bold">{{__('file.Tab - 2')}}</h4><br>
<div class="form-group row">
    <label class="col-sm-4 col-form-label"><b>@lang('file.Title')</b></label>
    <div class="col-sm-8">
        <!-- DB_ROW_ID-88:  => setting[87] -->
        <input type="text" name="storefront_product_tabs_1_section_tab_2_title" class="form-control" placeholder="@lang('file.Title')"
        @forelse ($setting[87]->settingTranslations as $key => $item)
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
    <!-- DB_ROW_ID-89:  => setting[88] -->
    <div class="col-sm-8">
        <select name="storefront_product_tabs_1_section_tab_2_product_type" id="storefrontProductTabs_1_SectionTab_2_ProductType" class="form-control" data-live-search="true" data-live-search-style="begins">
            <option value="">-- Select Type --</option>
            <option value="{{__('category_products')}}" selected>{{__('Category Products')}}</option>
        </select>
    </div>
</div>
@if ((!empty($setting[88]->plain_value)) && ($setting[88]->plain_value == 'category_products'))
    <div class="form-group row" id="categoryFeild_2">
        <label class="col-sm-4 col-form-label"><b>@lang('file.Category')</b></label>
        <div class="col-sm-8">
            <!-- DB_ROW_ID-90:  => setting[90] -->
            <select name="storefront_product_tabs_1_section_tab_2_category_id" id="storefrontProductTabs_1_SectionTab_2_CategoryId" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('Select Category')}}'>
                @foreach ($categories as $item)
                    @forelse ($item->categoryTranslation as $key => $value)
                        @if ($value->local==$locale)
                            <option value="{{$item->id}}" {{ $setting[89]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                        @elseif($value->local=='en')
                            <option value="{{$item->id}}" {{ $setting[89]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                        @endif
                    @empty
                        <option value="">{{__('NULL')}}</option>
                    @endforelse
                @endforeach
            </select>
        </div>
    </div>
@else
    <div class="form-group row" id="categoryFeild_2">
        <label class="col-sm-4 col-form-label"><b>@lang('file.Category')</b></label>
        <div class="col-sm-8">
            <!-- DB_ROW_ID-90:  => setting[89] -->
            <select name="storefront_product_tabs_1_section_tab_2_category_id" id="storefrontProductTabs_1_SectionTab_2_CategoryId" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('file.Select Category')}}'>
                @foreach ($categories as $item)
                    @forelse ($item->categoryTranslation as $key => $value)
                        @if ($value->local==$locale)
                            <option value="{{$item->id}}" {{ $setting[89]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                        @elseif($value->local=='en')
                            <option value="{{$item->id}}" {{ $setting[89]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                        @endif
                    @empty
                        <option value="">{{__('NULL')}}</option>
                    @endforelse
                @endforeach
            </select>
        </div>
    </div>
@endif

<div class="form-group row" id="productTabsField_2">
    @if ((!empty($setting[88]->plain_value)) && ($setting[88]->plain_value == 'custom_products'))
        <label class="col-sm-4 col-form-label"><b> {{__('file.Products')}}</b></label>
        <!-- DB_ROW_ID-91:  => setting[90] -->
        <div class="col-sm-8">
            <input type="text" name="storefront_product_tabs_1_section_tab_2_products" value="{{$setting[90]->plain_value}}" class="form-control">
        </div>
    @elseif((!empty($setting[88]->plain_value)) && (($setting[88]->plain_value == 'latest_products') || ($setting[88]->plain_value == 'recently_viewed_products')))
        <label class="col-sm-4 col-form-label"><b> {{__('file.Products Limit')}}</b></label>
        <!-- DB_ROW_ID-92:  => setting[91] -->
        <div class="col-sm-8">
            <input type="text" name="storefront_product_tabs_1_section_tab_2_products_limit" value="{{$setting[91]->plain_value}}" class="form-control">
        </div>
    @endif
</div>
