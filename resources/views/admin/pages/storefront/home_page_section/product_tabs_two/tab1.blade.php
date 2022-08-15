<h4 class="mt-3 text-bold">{{__('Tab - 1')}}</h4><br>
    <div class="form-group row">
        <label class="col-sm-4 col-form-label"><b>Title</b></label>
        <!-- DB_ROW_ID-105:  => setting[104] -->
        <div class="col-sm-8">
            <input type="text" name="storefront_product_tabs_2_section_tab_1_title" class="form-control" placeholder="Type Title"
            @forelse ($setting[104]->settingTranslations as $key => $item)
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
        <!-- DB_ROW_ID-106:  => setting[105] -->
        <div class="col-sm-8">
            <select name="storefront_product_tabs_2_section_tab_1_product_type" id="storefrontProductTabs_2_SectionTab_1_ProductType" class="form-control" data-live-search="true" data-live-search-style="begins">
                <option value="">-- Select Type --</option>
                <option value="{{__('category_products')}}" {{ $setting[105]->plain_value == 'category_products' ? 'selected="selected"' : '' }}>{{__('Category Products')}}</option>
                <option value="{{__('custom_products')}}" {{ $setting[105]->plain_value == 'custom_products' ? 'selected="selected"' : '' }}>{{__('Custom Products')}}</option>
                <option value="{{__('latest_products')}}" {{ $setting[105]->plain_value == 'latest_products' ? 'selected="selected"' : '' }}>{{__('Latest Products')}}</option>
                <option value="{{__('recently_viewed_products')}}" {{ $setting[105]->plain_value == 'recently_viewed_products' ? 'selected="selected"' : '' }}>{{__('Recently Viewed Products')}}</option>
            </select>
        </div>
    </div>
    @if ((!empty($setting[105]->plain_value)) && ($setting[105]->plain_value == 'category_products'))
        <div class="form-group row" id="tabTwoCategoryFeild_1">
            <label class="col-sm-4 col-form-label"><b>Category</b></label>
            <div class="col-sm-8">
                <!-- DB_ROW_ID-107:  => setting[106] -->
                <select name="storefront_product_tabs_2_section_tab_1_category_id" id="storefrontProductTabs_2_SectionTab_1_CategoryId" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('Select Category')}}'>
                    @foreach ($categories as $item)
                        @forelse ($item->categoryTranslation as $key => $value)
                            @if ($value->local==$locale)
                                <option value="{{$item->id}}" {{ $setting[106]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                            @elseif($value->local=='en')
                                <option value="{{$item->id}}" {{ $setting[106]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                            @endif
                        @empty
                            <option value="">{{__('NULL')}}</option>
                        @endforelse
                    @endforeach
                </select>
            </div>
        </div>
    @else
        <div class="form-group row" id="tabTwoCategoryFeild_1">
            <label class="col-sm-4 col-form-label"><b>Category</b></label>
            <div class="col-sm-8">
                <!-- DB_ROW_ID-107:  => setting[106] -->
                <select name="storefront_product_tabs_2_section_tab_1_category_id" id="storefrontProductTabs_2_SectionTab_1_CategoryId" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title='{{__('Select Category')}}'>
                    @foreach ($categories as $item)
                        @forelse ($item->categoryTranslation as $key => $value)
                            @if ($value->local==$locale)
                                <option value="{{$item->id}}" {{ $setting[106]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                            @elseif($value->local=='en')
                                <option value="{{$item->id}}" {{ $setting[106]->plain_value == $item->id ? 'selected="selected"' : '' }}>{{$value->category_name}}</option>
                            @endif
                        @empty
                            <option value="">{{__('NULL')}}</option>
                        @endforelse
                    @endforeach
                </select>
            </div>
        </div>
    @endif
    <div class="form-group row" id="tabTwoProductTabsField_1">
        @if ((!empty($setting[105]->plain_value)) && ($setting[105]->plain_value == 'custom_products'))
            <label class="col-sm-4 col-form-label"><b> {{__('Products')}}</b></label>
            <!-- DB_ROW_ID-108:  => setting[107] -->
            <div class="col-sm-8">
                <input type="text" name="storefront_product_tabs_2_section_tab_1_products" value="{{$setting[107]->plain_value}}" class="form-control">
            </div>
        @elseif((!empty($setting[105]->plain_value)) && (($setting[105]->plain_value == 'latest_products') || ($setting[105]->plain_value == 'recently_viewed_products')))
            <label class="col-sm-4 col-form-label"><b> {{__('Products Limit')}}</b></label>
            <!-- DB_ROW_ID-109:  => setting[108] -->
            <div class="col-sm-8">
                <input type="text" name="storefront_product_tabs_2_section_tab_1_products_limit" value="{{$setting[108]->plain_value}}" class="form-control">
            </div>
        @endif
    </div>
