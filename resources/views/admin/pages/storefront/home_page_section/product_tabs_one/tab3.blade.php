<h4 class="mt-3 text-bold">{{__('file.Tab - 3')}}</h4><br>
<div class="form-group row">
    <label class="col-sm-4 col-form-label"><b>@lang('file.Title')</b></label>
    <div class="col-sm-8">
        <!-- DB_ROW_ID-93:  => setting[92] -->
        <input type="text" name="storefront_product_tabs_1_section_tab_3_title" class="form-control" placeholder="@lang('file.Title')"
        @forelse ($setting[92]->settingTranslations as $key => $item)
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
    <!-- DB_ROW_ID-94:  => setting[93] -->
    <div class="col-sm-8">
        <select name="storefront_product_tabs_1_section_tab_3_product_type" id="storefrontProductTabs_1_SectionTab_3_ProductType" class="form-control" data-live-search="true" data-live-search-style="begins">
            <option value="">@lang('file.-- Select Type --')</option>
            <option value="{{__('category_products')}}" selected>{{__('Category Products')}}</option>
        </select>
    </div>
</div>
@if ((!empty($setting[93]->plain_value)) && ($setting[93]->plain_value == 'category_products'))
    <div class="form-group row" id="categoryFeild_3">
        <label class="col-sm-4 col-form-label"><b>@lang('file.Category')</b></label>
        <div class="col-sm-8">
            <!-- DB_ROW_ID-95:  => setting[95] -->
            <select name="storefront_product_tabs_1_section_tab_3_category_id" id="storefrontProductTabs_1_SectionTab_3_CategoryId" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('file.Select Category')}}'>
                @foreach ($categories as $item)
                    @forelse ($item->categoryTranslation as $key => $value)
                        @if ($value->local==$locale)
                            <option value="{{$item->id}}" {{ $setting[94]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                        @elseif($value->local=='en')
                            <option value="{{$item->id}}" {{ $setting[94]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                        @endif
                    @empty
                        <option value="">{{__('NULL')}}</option>
                    @endforelse
                @endforeach
            </select>
        </div>
    </div>
@else
    <div class="form-group row" id="categoryFeild_3">
        <label class="col-sm-4 col-form-label"><b>@lang('file.Category')</b></label>
        <div class="col-sm-8">
            <!-- DB_ROW_ID-95:  => setting[95] -->
            <select name="storefront_product_tabs_1_section_tab_3_category_id" id="storefrontProductTabs_1_SectionTab_3_CategoryId" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('Select Category')}}'>
                @foreach ($categories as $item)
                    @forelse ($item->categoryTranslation as $key => $value)
                        @if ($value->local==$locale)
                            <option value="{{$item->id}}" {{ $setting[94]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                        @elseif($value->local=='en')
                            <option value="{{$item->id}}" {{ $setting[94]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                        @endif
                    @empty
                        <option value="">{{__('NULL')}}</option>
                    @endforelse
                @endforeach
            </select>
        </div>
    </div>
@endif

<div class="form-group row" id="productTabsField_3">
    @if ((!empty($setting[93]->plain_value)) && ($setting[93]->plain_value == 'custom_products'))
        <label class="col-sm-4 col-form-label"><b> {{__('file.Products')}}</b></label>
        <!-- DB_ROW_ID-96:  => setting[95] -->
        <div class="col-sm-8">
            <input type="text" name="storefront_product_tabs_1_section_tab_3_products" value="{{$setting[95]->plain_value}}" class="form-control">
        </div>
    @elseif((!empty($setting[93]->plain_value)) && (($setting[93]->plain_value == 'latest_products') || ($setting[93]->plain_value == 'recently_viewed_products')))
        <label class="col-sm-4 col-form-label"><b> {{__('file.Products Limit')}}</b></label>
        <!-- DB_ROW_ID-97:  => setting[96] -->
        <div class="col-sm-8">
            <input type="text" name="storefront_product_tabs_1_section_tab_3_products_limit" value="{{$setting[96]->plain_value}}" class="form-control">
        </div>
    @endif
</div>





